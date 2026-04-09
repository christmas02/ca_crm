# Modèles Eloquent

Ce fichier documente tous les modèles Eloquent de l'application, leurs champs, relations et méthodes utilitaires.

---

## Role

**Fichier :** `app/Models/Role.php`  
**Table :** `roles`

Représente un rôle utilisateur. Les rôles sont peuplés par le seeder et ne sont pas modifiables par l'interface.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `name` | string | Libellé affiché (ex: "Administrateur") |
| `slug` | string | Identifiant technique (ex: `admin`, `lead`, `agent_terrain`, `agent_conseil`, `agent_conseil_renouvellement`) |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `users()` | hasMany → User | Utilisateurs ayant ce rôle |

---

## Status

**Fichier :** `app/Models/Status.php`  
**Table :** `statuses`

Représente le statut d'une opportunité. Peuplé par seeder.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `name` | string | Libellé affiché |
| `slug` | string | Identifiant technique (`nouvelle`, `rendez_vous`, `poursuivre`, `gagne`, `perdus`, `reporter`) |
| `group` | string | Groupe pour les statistiques du dashboard |
| `order` | int | Ordre d'affichage dans les filtres |
| `color` | string | Couleur hexadécimale pour l'affichage visuel |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `opportunities()` | hasMany → Opportunity | Opportunités ayant ce statut |

---

## Team

**Fichier :** `app/Models/Team.php`  
**Table :** `teams`

Représente une équipe commerciale. Chaque utilisateur appartient à une équipe.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `name` | string | Nom de l'équipe |
| `description` | string\|null | Description optionnelle |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `users()` | hasMany → User | Membres de l'équipe |
| `opportunities()` | hasMany → Opportunity | Opportunités rattachées à cette équipe |

---

## User

**Fichier :** `app/Models/User.php`  
**Table :** `users`

Utilisateur authentifié. Hérite de `Authenticatable`. Utilise Sanctum pour les tokens API.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `name` | string | Nom complet de l'utilisateur |
| `identification` | string | Identifiant de connexion unique (remplace `email`) |
| `password` | string | Mot de passe hashé (masqué dans les sérialisations) |
| `role_id` | int (FK) | Référence vers `roles.id` |
| `team_id` | int\|null (FK) | Référence vers `teams.id` |
| `actif` | boolean | Indique si le compte est actif |
| `remember_token` | string\|null | Token de session persistante (masqué) |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `role()` | belongsTo → Role | Rôle de l'utilisateur |
| `team()` | belongsTo → Team | Équipe de l'utilisateur |
| `createdOpportunities()` | hasMany → Opportunity (created_by) | Opportunités créées par cet utilisateur |
| `assignedOpportunities()` | hasMany → Opportunity (assigned_to) | Opportunités affectées à cet utilisateur |
| `comments()` | hasMany → Comment | Commentaires postés par cet utilisateur |

### Méthodes utilitaires

| Méthode | Retour | Description |
|---------|--------|-------------|
| `hasRole($slug)` | bool | Vérifie si l'utilisateur a exactement ce rôle |
| `hasAnyRole(array $slugs)` | bool | Vérifie si l'utilisateur a l'un des rôles listés |
| `isAdmin()` | bool | Raccourci : `hasRole('admin')` |
| `isLead()` | bool | Raccourci : `hasRole('lead')` |
| `isAgentConseil()` | bool | Raccourci : `hasRole('agent_conseil')` |
| `isAgentTerrain()` | bool | Raccourci : `hasRole('agent_terrain')` |
| `isAgentConseilRenouvellement()` | bool | Raccourci : `hasRole('agent_conseil_renouvellement')` |

### Scopes

| Scope | Description |
|-------|-------------|
| `scopeActive($query)` | Filtre les utilisateurs avec `actif = true` |

---

## Client

**Fichier :** `app/Models/Client.php`  
**Table :** `clients`

Représente un client converti (opportunité passée au statut "Gagné"). Les clients sont créés automatiquement par l'`OpportunityController` lors du passage au statut `gagne`.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `nom` | string | Nom de famille |
| `prenoms` | string\|null | Prénoms |
| `telephone` | string | Numéro principal (utilisé comme clé unique lors de la création automatique) |
| `telephone2` | string\|null | Numéro secondaire |
| `plaque_immatriculation` | string\|null | Plaque du véhicule |
| `assureur_actuel` | string\|null | Assureur au moment de la conversion |
| `lieuprospection` | string\|null | Lieu de prospection |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `opportunities()` | hasMany → Opportunity | Historique des opportunités du client |

### Accesseurs

| Accesseur | Description |
|-----------|-------------|
| `full_name` | Retourne `prenoms + nom` (trim) |

---

## Opportunity

**Fichier :** `app/Models/Opportunity.php`  
**Table :** `opportunities`

Modèle central de l'application. Représente une piste commerciale tout au long de son cycle de vie.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `client_id` | int\|null (FK) | Client associé (renseigné au statut Gagné) |
| `created_by` | int (FK) | Utilisateur créateur |
| `assigned_to` | int\|null (FK) | Agent conseil en charge |
| `status_id` | int (FK) | Statut courant |
| `team_id` | int\|null (FK) | Équipe rattachée |
| `insurance_partner_id` | int\|null (FK) | Partenaire assureur sélectionné |
| `nom` | string | Nom du prospect |
| `prenoms` | string | Prénoms du prospect |
| `telephone` | string | Téléphone principal |
| `telephone2` | string\|null | Téléphone secondaire |
| `title` | string\|null | Titre / objet de l'opportunité |
| `observation` | text\|null | Notes libres |
| `canal` | string\|null | Canal de prospection (ex: terrain, téléphone) |
| `source` | string\|null | Source (ex: `hors_cible`) |
| `plaque_immatriculation` | string\|null | Plaque du véhicule |
| `echeance` | datetime\|null | Date d'échéance du contrat à renouveler |
| `relance` | datetime\|null | Date de prochaine relance |
| `lieuprospection` | string\|null | Lieu de prospection |
| `assureur_actuel` | string\|null | Assureur actuel du prospect |
| `periode_souscription` | int\|null | Durée souscription en mois |
| `montant_souscription` | int\|null | Montant TTC en FCFA |
| `isasap` | string\|null | Indicateur urgence |
| `urlcarte_grise_terrain` | string\|null | Chemin fichier carte grise (terrain) |
| `url_attestationassurance_terrain` | string\|null | Chemin fichier attestation (terrain) |
| `urlcarte_grise` | string\|null | Chemin fichier carte grise (back-office) |
| `url_attestationassurance` | string\|null | Chemin fichier attestation (back-office) |
| `contrat_assurance` | string\|null | Chemin fichier contrat d'assurance |
| `capture_paiement` | string\|null | Chemin fichier preuve de paiement |
| `statut_discours` | string\|null | Qualité du discours terrain (`ok` / `nok`) |
| `statut_carte_grise` | string\|null | Qualité carte grise (`ok` / `nok` / `no_flag`) |
| `statut_attestation` | string\|null | Qualité attestation (`ok` / `nok`) |
| `author_doublon_check` | string\|null | Auteur du contrôle doublon |
| `doublon_check` | boolean | Indique si doublon vérifié |
| `date_auth_doublon` | datetime\|null | Date d'autorisation doublon |
| `isvisible` | boolean\|null | Visibilité de l'opportunité |
| `carte_grise_client` | string\|null | Carte grise fournie par le client |

### Casts

| Champ | Cast |
|-------|------|
| `echeance` | datetime |
| `relance` | datetime |
| `date_auth_doublon` | datetime |
| `doublon_check` | boolean |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `client()` | belongsTo → Client | Client associé |
| `creator()` | belongsTo → User (created_by) | Créateur |
| `assignee()` | belongsTo → User (assigned_to) | Agent conseil en charge |
| `status()` | belongsTo → Status | Statut courant |
| `team()` | belongsTo → Team | Équipe |
| `insurancePartner()` | belongsTo → InsurancePartner | Partenaire assureur |
| `comments()` | hasMany → Comment | Commentaires |
| `assignments()` | hasMany → Assignment | Historique d'affectations |
| `contracts()` | hasMany → Contract | Contrats générés |

### Accesseurs

| Accesseur | Description |
|-----------|-------------|
| `full_name` | Retourne `prenoms + nom` (trim) |

---

## Assignment

**Fichier :** `app/Models/Assignment.php`  
**Table :** `assignments`

Historise chaque affectation d'une opportunité à un agent conseil. Une seule assignation est `active` à la fois par opportunité.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `opportunity_id` | int (FK) | Opportunité concernée |
| `assigned_by` | int (FK) | Utilisateur ayant effectué l'affectation |
| `assigned_to` | int (FK) | Agent conseil affecté |
| `status` | string | `active` ou `inactive` |
| `date_affect` | datetime | Date d'affectation (saisie manuellement lors d'un bulk assign) |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `opportunity()` | belongsTo → Opportunity | Opportunité concernée |
| `assigner()` | belongsTo → User (assigned_by) | Utilisateur ayant affecté |
| `assignee()` | belongsTo → User (assigned_to) | Agent conseil affecté |

---

## Comment

**Fichier :** `app/Models/Comment.php`  
**Table :** `comments`

Commentaire posté sur une opportunité. Créé aussi automatiquement lors de chaque mise à jour via le formulaire d'édition.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `opportunity_id` | int (FK) | Opportunité commentée |
| `user_id` | int (FK) | Auteur du commentaire |
| `body` | text | Contenu du commentaire |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `opportunity()` | belongsTo → Opportunity | Opportunité concernée |
| `user()` | belongsTo → User | Auteur |

---

## InsurancePartner

**Fichier :** `app/Models/InsurancePartner.php`  
**Table :** `insurance_partners`

Partenaire assureur avec lequel l'agence travaille. Sert à calculer automatiquement les commissions lors de la création d'un contrat.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `name` | string | Nom du partenaire (unique) |
| `email` | string | Email de contact (unique) |
| `telephone` | string\|null | Téléphone |
| `website` | string\|null | Site web |
| `description` | text\|null | Description |
| `logo` | string\|null | Chemin vers le logo uploadé |
| `commission_rate` | decimal(5,2) | Taux de commission en % |
| `active` | boolean | Indique si le partenaire est actif (affiché dans les formulaires) |

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `contracts()` | hasMany → Contract | Contrats liés à ce partenaire |

---

## Contract

**Fichier :** `app/Models/Contract.php`  
**Table :** `contracts`

Contrat d'assurance généré lors du passage d'une opportunité au statut "Gagné". Supporte le soft delete.

### Champs

| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Clé primaire |
| `opportunity_id` | int (FK) | Opportunité d'origine |
| `insurance_partner_id` | int (FK) | Partenaire assureur |
| `client_id` | int\|null (FK) | Client associé |
| `created_by` | int (FK) | Utilisateur créateur |
| `contract_number` | string | Numéro unique — format `CTR-XXXXXXXX` (nouveau) ou `CTR-XXXXXXXX-N` (renouvellement) |
| `contract_start_date` | date | Date de début |
| `contract_end_date` | date\|null | Date de fin |
| `contract_duration` | int\|null | Durée en mois |
| `net_premium` | decimal(10,2)\|null | Prime nette |
| `ttc_premium` | decimal(10,2)\|null | Prime TTC |
| `commission_rate` | decimal(5,2)\|null | Taux de commission |
| `commission_amount` | decimal(10,2)\|null | Montant commission calculé |
| `contract_document` | string\|null | Chemin fichier contrat |
| `attestation_document` | string\|null | Chemin fichier attestation |
| `payment_proof` | string\|null | Chemin fichier preuve de paiement |
| `status` | string | `active` / `inactive` / `terminated` / `renewed` |
| `observations` | text\|null | Notes |
| `deleted_at` | datetime\|null | Soft delete |

### Numérotation des contrats

- **Premier contrat** d'une opportunité : `CTR-XXXXXXXX` (ex: `CTR-6785AB3C`)
- **Renouvellements** : `CTR-XXXXXXXX-2`, `CTR-XXXXXXXX-3`, etc.
- La détection renouvellement dans les bordereaux utilise le pattern REGEXP `^CTR-[A-Z0-9]+-[0-9]+$`

### Relations

| Méthode | Type | Description |
|---------|------|-------------|
| `opportunity()` | belongsTo → Opportunity | Opportunité d'origine |
| `insurancePartner()` | belongsTo → InsurancePartner | Partenaire assureur |
| `client()` | belongsTo → Client | Client |
| `creator()` | belongsTo → User (created_by) | Créateur |

### Accesseurs / Méthodes

| Méthode | Retour | Description |
|---------|--------|-------------|
| `is_active` (accesseur) | bool | `true` si `status === 'active'` |
| `getCommissionFromNet()` | float\|null | Recalcule la commission depuis `net_premium * commission_rate / 100` |
