# Contrôleurs

Ce fichier documente tous les contrôleurs de l'application, leurs méthodes, la logique métier et les autorisations associées.

---

## DashboardController

**Fichier :** `app/Http/Controllers/DashboardController.php`  
**Route principale :** `GET /dashboard`  
**Accès :** Tous les rôles authentifiés

### Responsabilité

Affiche le tableau de bord personnalisé selon le rôle de l'utilisateur connecté. Chaque rôle voit des statistiques et des listes d'opportunités différentes.

### Méthodes publiques

#### `index(Request $request)`

Charge les données du dashboard selon le rôle :

| Rôle | Données chargées |
|------|-----------------|
| Admin | Total opportunités, total clients, total utilisateurs, 10 dernières opportunités, compteurs par groupe de statut |
| Lead | Idem Admin mais filtré sur son équipe |
| Agent Conseil | Liste des opportunités assignées |
| Agent Renouvellement | Liste des opportunités assignées |
| Agent Terrain | Liste des opportunités créées par lui |

Retourne la vue `dashboard` avec la variable `$data`.

#### `getStatOpportunities(Request $request)`

**Route :** `GET /dashboard/stat-opportunities`  
Endpoint JSON appelé en AJAX par le dashboard de l'agent conseil.  
Accepte un paramètre `stat_index` (0-3) et retourne la collection correspondante :
- `0` → Rendez-vous du jour
- `1` → Échéances de la semaine
- `2` → Nouvelles opportunités du jour
- `3` → Total des trois précédentes (union dédupliquée)

### Méthodes privées

| Méthode | Description |
|---------|-------------|
| `getCustomStats($user)` | Dispatch vers la méthode stats selon le rôle |
| `getAgentConseilStats($user)` | 4 compteurs : RDV du jour, échéances semaine, nouvelles, total |
| `getAgentTerrainStats($user)` | 4 compteurs : nouvelles créées, gagnées, perdues, total |
| `getLeadStats($user)` | 4 compteurs : total équipe, assignées, gagnées, perdues |
| `getAdminStats($user)` | 4 compteurs : total opp, total clients, total users, gagnées |
| `getGroupCounts($user)` | Compteurs par groupe de statut (pour le graphique) |
| `getAgentConseilOpportunitiesCollections($user)` | Collections Eloquent pour les stats conseil (réutilisée par `getStatOpportunities`) |

---

## OpportunityController

**Fichier :** `app/Http/Controllers/OpportunityController.php`  
**Routes :** Resource + routes supplémentaires  
**Accès :** Tous les rôles authentifiés (avec filtrage par rôle)

### Responsabilité

CRUD complet des opportunités + gestion des affectations, changements de statut, et logique automatique de création de client/contrat au passage au statut "Gagné".

### Méthodes publiques

#### `index(Request $request)`

**Route :** `GET /opportunities`  

Affiche la liste des opportunités filtrée selon le rôle :

| Rôle | Filtre appliqué |
|------|----------------|
| Admin | Toutes les opportunités |
| Lead | Opportunités de son `team_id` |
| Agent Conseil | Opportunités dont `assigned_to = user->id` |
| Agent Terrain | Opportunités dont `created_by = user->id` |
| Agent Renouvellement | Opportunités au statut `gagne` uniquement |

Filtres supplémentaires disponibles via query string : `status_id`, `search` (titre/nom/prénom/téléphone/plaque), `date_start`/`date_end` (échéance), `relance_start`/`relance_end`.

Pagination : 100 par page.

#### `listNewOpportunities()`

**Route :** `GET /opportunities/new`  

Affiche les opportunités actionnables pour l'agent conseil connecté.  
Utilise un JOIN sur la table `assignments` pour ne montrer que les assignations `active`.

Logique de visibilité (au moins une condition requise) :
- Statut `nouvelle` ET `date_affect <= aujourd'hui`
- Statut autre que `nouvelle`/`perdus` ET `relance <= aujourd'hui`

Pour les agents renouvellement : exclut `nouvelle` et `perdus` (au lieu de `gagne` et `perdus`).

#### `listRenewals()`

**Route :** `GET /opportunities/renewals`  
**Accès :** Admin et Lead uniquement

Affiche toutes les opportunités ayant au moins un contrat (`whereHas('contracts')`), triées par échéance ascendante. Vue dédiée au suivi des renouvellements.

#### `create()`

**Route :** `GET /opportunities/create`  
**Autorisation :** `OpportunityPolicy::create`

Formulaire de création. Passe les statuts et les partenaires d'assurance actifs à la vue.

#### `store(Request $request)`

**Route :** `POST /opportunities`  
**Autorisation :** `OpportunityPolicy::create`

Validation des champs requis, upload optionnel de deux fichiers (carte grise, attestation), puis création.  
- `created_by` = utilisateur connecté
- `status_id` = statut `nouvelle` automatiquement
- `team_id` = équipe de l'utilisateur connecté

#### `show(Opportunity $opportunity)`

**Route :** `GET /opportunities/{id}`  
**Autorisation :** `OpportunityPolicy::view`

Charge les relations : status, assignee, creator, team, comments.user, assignments.assigner, assignments.assignee.  
Passe également la liste des agents conseil (filtrée sur l'équipe si Lead) et tous les statuts.

#### `edit(Opportunity $opportunity)`

**Route :** `GET /opportunities/{id}/edit`  
**Autorisation :** `OpportunityPolicy::update`

Formulaire d'édition. Passe les statuts et les partenaires d'assurance actifs.

#### `update(Request $request, Opportunity $opportunity)`

**Route :** `PUT /opportunities/{id}`

Logique la plus complexe du projet — dans une transaction DB :

1. Valide et met à jour les champs
2. Gère l'upload/remplacement de 4 types de fichiers (carte grise, attestation, contrat, preuve de paiement)
3. Si statut → `gagne` :
   - Crée le client via `Client::firstOrCreate` (clé : `telephone`)
   - Si `assureur_actuel` correspond à un `InsurancePartner`, crée automatiquement un contrat avec calcul de commission
4. Crée toujours un commentaire automatique avec le champ `body`

#### `destroy(Opportunity $opportunity)`

**Route :** `DELETE /opportunities/{id}`  
**Autorisation :** `OpportunityPolicy::delete` (Admin uniquement)

Suppression simple.

#### `assign(Request $request, Opportunity $opportunity)`

**Route :** `POST /opportunities/{id}/assign`  
**Autorisation :** `OpportunityPolicy::assign` (Admin et Lead)

- Met les assignations actives existantes à `inactive`
- Crée une nouvelle assignation `active`
- Passe l'opportunité au statut `rendez_vous`

#### `bulkAssign(Request $request)`

**Route :** `POST /opportunities/bulk/assign`

Affecte en masse plusieurs opportunités à un agent conseil.  
Accepte : `opportunity_ids` (string d'IDs séparés par virgules), `assigned_to`, `date_affect`.  
Exécuté dans une transaction DB.

#### `changeStatus(Request $request, Opportunity $opportunity)`

**Route :** `POST /opportunities/{id}/status`  
**Autorisation :** `OpportunityPolicy::changeStatus`

Change le statut. Si passage à `gagne` : crée le client automatiquement (si pas encore créé).

### Méthodes privées

| Méthode | Description |
|---------|-------------|
| `storeFile($file, $folder)` | Upload un fichier dans `storage/app/public/$folder`, retourne le chemin relatif |
| `deleteFile($filePath)` | Supprime un fichier du disque `public` |
| `generateContractNumber($opportunityId)` | Génère `CTR-XXXXXXXX` pour le premier contrat, `CTR-XXXXXXXX-N` pour les suivants |

---

## ClientController

**Fichier :** `app/Http/Controllers/ClientController.php`  
**Routes :** `GET /clients`, `GET /clients/{id}`  
**Accès :** Tous les rôles authentifiés

### Responsabilité

Lecture seule des clients. Les clients sont créés automatiquement par l'`OpportunityController`.

### Méthodes

#### `index(Request $request)`

Liste paginée (20/page) avec recherche sur `nom`, `prenoms`, `telephone`, `plaque_immatriculation`.

#### `show(Client $client)`

Détail d'un client avec toutes ses opportunités (status, assignee, creator).

---

## ContractController

**Fichier :** `app/Http/Controllers/ContractController.php`  
**Routes :** Resource complet + `GET /opportunities/{id}/create-contract`  
**Accès :** Géré par `ContractPolicy`

### Responsabilité

CRUD des contrats d'assurance. La création automatique se fait via `OpportunityController::update`. Ce contrôleur permet la gestion manuelle.

### Méthodes

#### `index(Request $request)`

Liste paginée (15/page). Filtres : `status`, `insurance_partner_id`, `search` (numéro contrat, nom client, nom partenaire).

#### `create(Request $request)`

Formulaire de création. Accepte un `?opportunity_id` pour pré-remplir depuis une opportunité existante.

#### `store(Request $request)`

Valide et crée un contrat. Récupère automatiquement le `client_id` depuis l'opportunité si non fourni.

#### `show(Contract $contract)`

Détail d'un contrat avec ses relations (opportunity, insurancePartner, client, creator).

#### `edit(Contract $contract)` / `update(Request $request, Contract $contract)`

Édition avec gestion de l'upload/remplacement de 3 fichiers (contrat, attestation, preuve de paiement).

#### `destroy(Contract $contract)`

Supprime le contrat et ses fichiers associés.

#### `createFromOpportunity(Opportunity $opportunity)`

Redirige vers `contracts.create` uniquement si l'opportunité est au statut `gagne`.

---

## BordereauController

**Fichier :** `app/Http/Controllers/BordereauController.php`  
**Routes :** `GET /bordereaux/*`  
**Accès :** Lead et Admin uniquement

### Responsabilité

Rapports de performance et tableaux de bord analytiques. Toutes les méthodes vérifient manuellement l'accès (`isLead() || isAdmin()`).

### Méthodes

#### `index()`

Page d'index des bordereaux (liens vers les différents rapports).

#### `conseil(Request $request)`

**Rapport : Performance par agent conseil**

Filtres de date : `date_debut`/`date_fin` ou `date_specifique`.  
Pour chaque agent conseil/renouvellement actif, calcule via `calculerMetriques()` :

| Métrique | Définition |
|----------|-----------|
| `opp_jour` | Opportunités avec assignation active dans la période |
| `opp_modifiees` | Opportunités commentées par le conseiller dans la période |
| `total_renouvellement` | Contrats avec numéro `CTR-*-*` créés dans la période (statut gagne) |
| `opp_gagnees` | Contrats `CTR-*` créés dans la période (statut gagne) |
| `total_opp_affectees` | Opportunités affectées au conseiller dans la période |
| `taux_conversion` | `opp_gagnees / total_opp_affectees * 100` |
| `score` | `(contrats_renouveles / 3) + contrats_nouveaux` |

#### `contratsGagnes(Request $request)`

**Rapport : Détail des contrats gagnés par conseiller**

Calcule pour chaque conseiller : contrats nouveaux, contrats renouvelés, score, taux de conversion, prime nette/TTC/moyenne.

#### `contratsGagnesEquipe(Request $request)`

**Rapport : Détail des contrats gagnés par équipe**

Même logique que `contratsGagnes` mais agrégée par équipe (membres actifs uniquement). Filtre les équipes sans activité.

#### `statsComparatives(Request $request)`

**Rapport : Comparaison de deux périodes**

Compare période 1 (défaut : mois précédent) vs période 2 (défaut : mois actuel).  
Calcule les variations en % pour : opp_total, opp_traite, opp_gagnee, taux_conversion, affaires_nouvelles, chiffre_affaires, commission_total, nombre_contrats, prime_moyenne, score_moyen_equipe.

#### `agentsTerrain(Request $request)`

**Rapport : Performance des agents terrain**

Pour chaque agent terrain actif, calcule : opportunités remontées, cartes grises, discours OK/NOK, cartes grises OK/NOK/no_flag, opportunités hors cible/perdues, jours travaillés, contrats gagnés, taux de qualification.

---

## UserController

**Fichier :** `app/Http/Controllers/UserController.php`  
**Routes :** Resource (sauf `show`) → `GET/POST /users`, `GET/PUT/DELETE /users/{id}`  
**Accès :** Admin uniquement (middleware `role:admin`)

### Méthodes

| Méthode | Description |
|---------|-------------|
| `index()` | Liste paginée (20/page) avec rôle et équipe chargés |
| `create()` | Formulaire de création (passe tous les rôles et équipes) |
| `store()` | Valide, hashé le mot de passe, crée l'utilisateur |
| `edit(User $user)` | Formulaire d'édition |
| `update()` | Met à jour (le mot de passe n'est modifié que s'il est fourni) |
| `destroy(User $user)` | Supprime (interdit de supprimer son propre compte) |

---

## TeamController

**Fichier :** `app/Http/Controllers/TeamController.php`  
**Routes :** Resource (sauf `show`) → `GET/POST /teams`, `GET/PUT/DELETE /teams/{id}`  
**Accès :** Admin uniquement (middleware `role:admin`)

### Méthodes

CRUD standard. L'index charge le nombre d'utilisateurs par équipe (`withCount('users')`).

---

## InsurancePartnerController

**Fichier :** `app/Http/Controllers/InsurancePartnerController.php`  
**Routes :** Resource complet → `/insurance-partners`  
**Accès :** Admin uniquement (middleware `role:admin`) + `InsurancePartnerPolicy`

### Méthodes

CRUD complet avec gestion du logo (upload/suppression via `Storage::disk('public')`). Le champ `active` est forcé en boolean via `$request->boolean('active', true)`.

---

## CommentController

**Fichier :** `app/Http/Controllers/CommentController.php`  
**Route :** `POST /opportunities/{opportunity}/comments`  
**Accès :** Tous les rôles authentifiés

### Méthodes

#### `store(Request $request, Opportunity $opportunity)`

Crée un commentaire sur une opportunité. Seul le champ `body` est requis. L'`user_id` est celui de l'utilisateur connecté.

> **Note :** Un commentaire est aussi créé automatiquement par `OpportunityController::update` à chaque mise à jour d'une opportunité (champ `body` du formulaire d'édition).

---

## ProfileController

**Fichier :** `app/Http/Controllers/ProfileController.php`  
**Routes :** `GET/PATCH/DELETE /profile`  
**Accès :** Tous les rôles authentifiés

Contrôleur standard Laravel Breeze. Permet à l'utilisateur de modifier son profil et de supprimer son compte.

---

## Contrôleurs d'authentification (Auth/)

Contrôleurs standard fournis par Laravel Breeze. Non modifiés.

| Contrôleur | Route | Description |
|-----------|-------|-------------|
| `AuthenticatedSessionController` | `POST /login`, `POST /logout` | Connexion / déconnexion |
| `RegisteredUserController` | `POST /register` | Inscription (désactivée en production) |
| `PasswordResetLinkController` | `POST /forgot-password` | Envoi lien reset |
| `NewPasswordController` | `POST /reset-password` | Reset du mot de passe |
| `ConfirmablePasswordController` | `POST /confirm-password` | Confirmation mot de passe |
| `PasswordController` | `PUT /password` | Changement mot de passe profil |

---

## Contrôleurs API (Api/)

**Fichier :** `app/Http/Controllers/Api/AuthController.php` et `Api/CollectController.php`

Contrôleurs utilisés par une application mobile ou externe pour la collecte de données terrain via l'API Sanctum. Non documentés en détail ici (API séparée).
