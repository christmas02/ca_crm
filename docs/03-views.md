# Vues Blade

Ce fichier documente toutes les vues de l'application : ce que l'utilisateur voit et peut faire (niveau fonctionnel) ainsi que les variables reçues et la logique conditionnelle (niveau technique).

---

## Layouts

### `layouts/app.blade.php`

Layout principal de l'application authentifiée. Inclut la navigation latérale, la barre supérieure et le slot `content`.

**Variables attendues :** aucune (récupère l'utilisateur via `auth()->user()`)

**Logique conditionnelle :**
- La sidebar affiche le lien "Utilisateurs" uniquement si `auth()->user()->isAdmin()`
- Le lien "Équipes" uniquement si `auth()->user()->isAdmin()`
- Le lien "Partenaires d'assurance" uniquement si `auth()->user()->isAdmin()`
- Le lien "Bordereaux" uniquement si `isAdmin() || isLead()`
- Le lien "Renouvellements" uniquement si `isAdmin() || isLead()`

### `layouts/guest.blade.php`

Layout pour les pages d'authentification (login, register, reset password). Aucune navigation, fond centré.

### `layouts/navigation.blade.php`

Barre de navigation supérieure (responsive). Affiche le nom de l'utilisateur, le lien vers le profil et le bouton de déconnexion.

---

## Authentification (`auth/`)

Vues standard Laravel Breeze. Non modifiées.

| Vue | Route | Description |
|-----|-------|-------------|
| `auth/login.blade.php` | `GET /login` | Formulaire de connexion avec champ `identification` et `password` |
| `auth/register.blade.php` | `GET /register` | Formulaire d'inscription |
| `auth/forgot-password.blade.php` | `GET /forgot-password` | Formulaire d'envoi du lien de reset |
| `auth/reset-password.blade.php` | `GET /reset-password/{token}` | Formulaire de nouveau mot de passe |
| `auth/confirm-password.blade.php` | `GET /confirm-password` | Confirmation de sécurité |
| `auth/verify-email.blade.php` | `GET /verify-email` | Vérification d'email |

---

## Dashboard (`dashboard.blade.php`)

**Route :** `GET /dashboard`  
**Layout :** `layouts/app`

### Fonctionnel

Tableau de bord personnalisé. Chaque rôle voit un affichage différent :

- **Admin / Lead :** Tuiles de statistiques cliquables, liste des 10 dernières opportunités, compteurs par groupe de statut
- **Agent Conseil / Renouvellement :** Tuiles cliquables avec chargement AJAX d'une liste d'opportunités au clic, indicateurs (RDV du jour, échéances, nouvelles opportunités)
- **Agent Terrain :** Tuiles avec ses opportunités créées et un raccourci vers la création

### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$stats` | array | Tableau de tuiles `[label, value, color, icon, url?]` |
| `$totalOpportunities` | int | (Admin/Lead) Total des opportunités |
| `$groupCounts` | Collection | (Admin/Lead) Compteurs par groupe de statut |
| `$recentOpportunities` | Collection | (Admin/Lead) 10 dernières opportunités |
| `$totalClients` | int | (Admin/Lead) Nombre de clients |
| `$totalUsers` | int | (Admin/Lead) Nombre d'utilisateurs |
| `$assignedOpportunities` | Collection | (Conseil) Opportunités assignées |
| `$createdOpportunities` | Collection | (Terrain) Opportunités créées |

**Logique conditionnelle par rôle :**  
La vue utilise `$user->isAdmin()`, `$user->isLead()`, etc. pour afficher des blocs différents.

**AJAX :** Les tuiles de l'agent conseil déclenchent un appel `fetch` vers `/dashboard/stat-opportunities?stat_index=N` pour charger la liste correspondante sans recharger la page.

---

## Opportunités (`opportunities/`)

### `opportunities/index.blade.php`

**Route :** `GET /opportunities`  
**Layout :** `layouts/app`

#### Fonctionnel

Liste paginée des opportunités avec :
- Barre de filtres : statut (sélecteur), texte libre (nom, téléphone, plaque), plages de dates d'échéance et de relance
- Tableau des opportunités avec colonnes : nom, téléphone, plaque, statut (badge coloré), agent assigné, créateur, date de relance, date d'échéance
- Sélection multiple pour l'affectation en masse (case à cocher par ligne)
- Panneau d'affectation en masse : sélection de l'agent et de la date (visible uniquement si `isAdmin() || isLead()`)
- Lien "Nouvelle opportunité" (visible si autorisé)

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$opportunities` | LengthAwarePaginator | Opportunités paginées (100/page) avec relations status, assignee, creator, team |
| `$statuses` | Collection | Tous les statuts pour le filtre |

**Logique conditionnelle :**
- Le panneau bulk assign n'est affiché qu'aux Admin/Lead
- La colonne "Assigné à" est masquée pour les agents terrain

---

### `opportunities/renewals.blade.php`

**Route :** `GET /opportunities/renewals`  
**Layout :** `layouts/app`

#### Fonctionnel

Liste des opportunités ayant au moins un contrat (suivi renouvellements). Triée par échéance ascendante. Affiche la date d'échéance, le partenaire assureur, les commentaires et les contrats associés.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$opportunities` | LengthAwarePaginator | Opportunités avec contracts, status, client, team, insurancePartner, comments |
| `$statuses` | Collection | Statuts pour les filtres |
| `$user` | User | (Admin/Lead) Utilisateur connecté |

---

### `opportunities/show.blade.php`

**Route :** `GET /opportunities/{id}`  
**Layout :** `layouts/app`

#### Fonctionnel

Fiche détaillée d'une opportunité. Affiche :
- Informations du prospect (nom, téléphones, plaque, lieu de prospection)
- Informations assurance (assureur actuel, période, montant, ASAP)
- Statut courant avec boutons de changement rapide
- Documents uploadés (carte grise, attestation) avec liens de téléchargement
- Historique des affectations (tableau : date, assigné par, assigné à)
- Commentaires (liste chronologique + formulaire d'ajout)
- Bouton d'affectation à un agent conseil (visible si Admin/Lead)
- Bouton "Modifier" (si autorisé)
- Lien vers la création de contrat (si statut = Gagné)

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$opportunity` | Opportunity | Avec relations chargées (status, assignee, creator, team, comments.user, assignments) |
| `$conseilUsers` | Collection | Agents conseil disponibles pour l'affectation |
| `$statuses` | Collection | Tous les statuts |

**Logique conditionnelle :**
- Le formulaire d'affectation n'est visible qu'aux Admin/Lead
- Le bouton "Changer le statut" respecte la `OpportunityPolicy::changeStatus`
- Les boutons de documents n'apparaissent que si les fichiers existent (`$opportunity->urlcarte_grise != null`)

---

### `opportunities/create.blade.php`

**Route :** `GET /opportunities/create`  
**Layout :** `layouts/app`

#### Fonctionnel

Formulaire de création d'une nouvelle opportunité. Champs : nom, prénoms, téléphone, canal, plaque d'immatriculation, lieu de prospection, assureur actuel, urgence (ASAP), date d'échéance, observation, upload carte grise et attestation.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$statuses` | Collection | Statuts disponibles |
| `$insurancePartners` | Collection | Partenaires actifs pour le sélecteur |

Formulaire en `enctype="multipart/form-data"`.

---

### `opportunities/edit.blade.php`

**Route :** `GET /opportunities/{id}/edit`  
**Layout :** `layouts/app`

#### Fonctionnel

Formulaire d'édition complet. Comprend tous les champs de la fiche + les champs back-office (statuts des documents : discours, carte grise, attestation) + un champ commentaire obligatoire.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$opportunity` | Opportunity | Données actuelles pré-remplies |
| `$statuses` | Collection | Statuts pour le sélecteur |
| `$insurancePartners` | Collection | Partenaires actifs |

Affiche les fichiers existants avec leur lien + possibilité d'en uploader de nouveaux.  
Inclut un champ `body` (commentaire requis) qui est enregistré automatiquement à chaque update.

---

### `opportunities/block.blade.php`

Vue d'erreur d'accès bloqué (403). Affichée lorsque l'utilisateur n'a pas les droits sur une opportunité.

---

## Clients (`clients/`)

### `clients/index.blade.php`

**Route :** `GET /clients`  
**Layout :** `layouts/app`

#### Fonctionnel

Liste paginée des clients avec barre de recherche (nom, prénom, téléphone, plaque). Affiche le nombre d'opportunités par client.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$clients` | LengthAwarePaginator | Clients avec `opportunities_count` |

---

### `clients/show.blade.php`

**Route :** `GET /clients/{id}`  
**Layout :** `layouts/app`

#### Fonctionnel

Fiche client avec ses informations et l'historique complet de ses opportunités (statut, agent assigné, créateur).

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$client` | Client | Avec `opportunities.status`, `opportunities.assignee`, `opportunities.creator` |

---

## Bordereaux (`bordereaux/`)

Toutes les vues bordereaux sont réservées aux Admin et Lead.

### `bordereaux/index.blade.php`

**Route :** `GET /bordereaux`

Page d'index avec liens vers les 5 rapports disponibles.

---

### `bordereaux/conseil.blade.php`

**Route :** `GET /bordereaux/conseil`

#### Fonctionnel

Tableau des performances de chaque agent conseil pour une période donnée. Filtres de date en en-tête. Colonnes : nom du conseiller, opp. du jour, opp. modifiées, total renouvellements, opp. gagnées, total affectées, taux de conversion, score.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$donnees` | Collection | Tableaux de métriques par conseiller |
| `$dateDebut` | Carbon | Date de début du filtre |
| `$dateFin` | Carbon | Date de fin du filtre |

---

### `bordereaux/contrats-gagnes.blade.php`

**Route :** `GET /bordereaux/contrats-gagnes`

#### Fonctionnel

Tableau de performance commerciale par conseiller : contrats nouveaux, contrats renouvelés, score, taux de conversion, prime nette, prime TTC, prime moyenne.

#### Technique

**Variables reçues :** `$donnees`, `$dateDebut`, `$dateFin`

---

### `bordereaux/contrats-gagnes-equipe.blade.php`

**Route :** `GET /bordereaux/contrats-gagnes-equipe`

Même structure que `contrats-gagnes` mais agrégée par équipe.

**Variables reçues :** `$donnees`, `$dateDebut`, `$dateFin`

---

### `bordereaux/stats-comparatives.blade.php`

**Route :** `GET /bordereaux/stats-comparatives`

#### Fonctionnel

Tableau comparatif de deux périodes côte à côte avec indicateurs de variation (+/-%). Métriques affichées : opp. totales, opp. traitées, opp. gagnées, taux de conversion, affaires nouvelles, chiffre d'affaires, commissions, nombre de contrats, prime moyenne, score moyen.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$metriques_p1` | array | Métriques période 1 |
| `$metriques_p2` | array | Métriques période 2 |
| `$variations` | array | Variations en % (clés identiques aux métriques) |
| `$p1_debut`, `$p1_fin`, `$p2_debut`, `$p2_fin` | Carbon | Bornes des périodes |

---

### `bordereaux/agents-terrain.blade.php`

**Route :** `GET /bordereaux/agents-terrain`

#### Fonctionnel

Tableau de suivi terrain : opportunités remontées, cartes grises reçues, qualité des discours (OK/NOK), qualité des cartes grises (OK/NOK/sans flag), hors cible, perdues, jours travaillés, contrats gagnés, taux de qualification.

#### Technique

**Variables reçues :**

| Variable | Type | Description |
|----------|------|-------------|
| `$metriques` | Collection | Tableaux de métriques par agent terrain, triés par `opp_remontees` décroissant |
| `$dateDebut`, `$dateFin` | Carbon | Bornes du filtre |

---

## Utilisateurs (`users/`)

Vues réservées à l'Admin.

### `users/index.blade.php`

**Route :** `GET /users`

Liste paginée des utilisateurs avec rôle et équipe. Liens vers création, édition, suppression.

**Variables :** `$users` (paginé avec role, team)

---

### `users/create.blade.php` et `users/edit.blade.php`

Formulaires de création/édition d'un utilisateur. Champs : nom, identification (login), mot de passe, rôle (sélecteur), équipe (sélecteur), statut actif.

**Variables :** `$roles`, `$teams` (et `$user` pour l'édition)

---

## Équipes (`teams/`)

Vues réservées à l'Admin.

### `teams/index.blade.php`

Liste des équipes avec nombre de membres. Liens vers création, édition, suppression.

**Variables :** `$teams` (avec `users_count`)

---

### `teams/create.blade.php` et `teams/edit.blade.php`

Formulaires de création/édition. Champs : nom, description.

**Variables :** aucune / `$team`

---

## Partenaires d'assurance (`insurance_partners/`)

Vues réservées à l'Admin.

### `insurance_partners/index.blade.php`

Liste paginée des partenaires avec statut actif/inactif et taux de commission.

**Variables :** `$partners` (paginé)

---

### `insurance_partners/show.blade.php`

Fiche détaillée d'un partenaire : logo, coordonnées, taux de commission, liste des contrats associés.

**Variables :** `$insurancePartner`

---

### `insurance_partners/create.blade.php` et `insurance_partners/edit.blade.php`

Formulaires CRUD. Champs : nom, email, téléphone, site web, description, logo (upload image), taux de commission, actif (toggle).

**Variables :** aucune / `$insurancePartner`

---

## Profil (`profile/`)

### `profile/edit.blade.php`

Page de profil de l'utilisateur connecté. Contient 3 sous-formulaires via des partials :

| Partial | Description |
|---------|-------------|
| `partials/update-profile-information-form.blade.php` | Modifier nom et identification |
| `partials/update-password-form.blade.php` | Changer le mot de passe |
| `partials/delete-user-form.blade.php` | Supprimer son compte |

---

## Composants réutilisables (`components/`)

Composants Blade anonymes fournis par Laravel Breeze. Utilisés dans tout le projet.

| Composant | Description |
|-----------|-------------|
| `application-logo` | Logo de l'application |
| `auth-session-status` | Message de session (succès/erreur après redirect) |
| `danger-button` | Bouton rouge (actions destructives) |
| `primary-button` | Bouton principal (submit) |
| `secondary-button` | Bouton secondaire |
| `dropdown` | Menu déroulant Alpine.js |
| `dropdown-link` | Lien dans un dropdown |
| `input-label` | Label de champ de formulaire |
| `text-input` | Champ de saisie stylisé |
| `input-error` | Message d'erreur de validation sous un champ |
| `modal` | Modale Alpine.js générique |
| `nav-link` | Lien de navigation avec état actif |
| `responsive-nav-link` | Lien de navigation mobile |
