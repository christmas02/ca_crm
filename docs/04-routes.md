# Routes

Ce fichier liste toutes les routes de l'application avec leur méthode HTTP, leur URI, le contrôleur/action associé, le nom de route et les droits d'accès requis.

---

## Routes publiques (non authentifiées)

| Méthode | URI | Action | Description |
|---------|-----|--------|-------------|
| GET | `/` | Redirect → `login` | Redirige vers la page de connexion |
| GET | `/login` | `AuthenticatedSessionController@create` | Formulaire de connexion |
| POST | `/login` | `AuthenticatedSessionController@store` | Traitement connexion |
| POST | `/logout` | `AuthenticatedSessionController@destroy` | Déconnexion |
| GET | `/register` | `RegisteredUserController@create` | Formulaire d'inscription |
| POST | `/register` | `RegisteredUserController@store` | Traitement inscription |
| GET | `/forgot-password` | `PasswordResetLinkController@create` | Formulaire reset |
| POST | `/forgot-password` | `PasswordResetLinkController@store` | Envoi lien reset |
| GET | `/reset-password/{token}` | `NewPasswordController@create` | Formulaire nouveau mot de passe |
| POST | `/reset-password` | `NewPasswordController@store` | Traitement reset |

---

## Routes authentifiées (middleware `auth`)

### Dashboard

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/dashboard` | `dashboard` | `DashboardController@index` | Tous |
| GET | `/dashboard/stat-opportunities` | `dashboard.stat-opportunities` | `DashboardController@getStatOpportunities` | Tous |

---

### Profil

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/profile` | `profile.edit` | `ProfileController@edit` | Tous |
| PATCH | `/profile` | `profile.update` | `ProfileController@update` | Tous |
| DELETE | `/profile` | `profile.destroy` | `ProfileController@destroy` | Tous |

---

### Opportunités

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/opportunities` | `opportunities.index` | `OpportunityController@index` | Tous (filtré par rôle) |
| GET | `/opportunities/new` | `opportunities.new` | `OpportunityController@listNewOpportunities` | Agent Conseil, Renouvellement |
| GET | `/opportunities/renewals` | `opportunities.renewals` | `OpportunityController@listRenewals` | Admin, Lead |
| GET | `/opportunities/create` | `opportunities.create` | `OpportunityController@create` | Policy: create |
| POST | `/opportunities` | `opportunities.store` | `OpportunityController@store` | Policy: create |
| GET | `/opportunities/{id}` | `opportunities.show` | `OpportunityController@show` | Policy: view |
| GET | `/opportunities/{id}/edit` | `opportunities.edit` | `OpportunityController@edit` | Policy: update |
| PUT/PATCH | `/opportunities/{id}` | `opportunities.update` | `OpportunityController@update` | Policy: update |
| DELETE | `/opportunities/{id}` | `opportunities.destroy` | `OpportunityController@destroy` | Policy: delete (Admin) |
| POST | `/opportunities/{id}/assign` | `opportunities.assign` | `OpportunityController@assign` | Policy: assign (Admin, Lead) |
| POST | `/opportunities/bulk/assign` | `opportunities.bulkAssign` | `OpportunityController@bulkAssign` | Tous authentifiés |
| POST | `/opportunities/{id}/status` | `opportunities.change-status` | `OpportunityController@changeStatus` | Policy: changeStatus |

---

### Commentaires

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| POST | `/opportunities/{opportunity}/comments` | `comments.store` | `CommentController@store` | Tous |

---

### Clients

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/clients` | `clients.index` | `ClientController@index` | Tous |
| GET | `/clients/{id}` | `clients.show` | `ClientController@show` | Tous |

---

### Contrats

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/contracts` | `contracts.index` | `ContractController@index` | Policy: viewAny |
| GET | `/contracts/create` | `contracts.create` | `ContractController@create` | Policy: create |
| POST | `/contracts` | `contracts.store` | `ContractController@store` | Policy: create |
| GET | `/contracts/{id}` | `contracts.show` | `ContractController@show` | Policy: view |
| GET | `/contracts/{id}/edit` | `contracts.edit` | `ContractController@edit` | Policy: update |
| PUT/PATCH | `/contracts/{id}` | `contracts.update` | `ContractController@update` | Policy: update |
| DELETE | `/contracts/{id}` | `contracts.destroy` | `ContractController@destroy` | Policy: delete |
| GET | `/opportunities/{id}/create-contract` | `opportunities.create-contract` | `ContractController@createFromOpportunity` | Authentifié |

---

### Bordereaux (middleware `role:lead,admin`)

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/bordereaux` | `bordereaux.index` | `BordereauController@index` | Lead, Admin |
| GET | `/bordereaux/conseil` | `bordereaux.conseil` | `BordereauController@conseil` | Lead, Admin |
| GET | `/bordereaux/contrats-gagnes` | `bordereaux.contrats-gagnes` | `BordereauController@contratsGagnes` | Lead, Admin |
| GET | `/bordereaux/contrats-gagnes-equipe` | `bordereaux.contrats-gagnes-equipe` | `BordereauController@contratsGagnesEquipe` | Lead, Admin |
| GET | `/bordereaux/stats-comparatives` | `bordereaux.stats-comparatives` | `BordereauController@statsComparatives` | Lead, Admin |
| GET | `/bordereaux/agents-terrain` | `bordereaux.agents-terrain` | `BordereauController@agentsTerrain` | Lead, Admin |

---

### Administration (middleware `role:admin`)

| Méthode | URI | Nom de route | Contrôleur | Rôles |
|---------|-----|-------------|-----------|-------|
| GET | `/users` | `users.index` | `UserController@index` | Admin |
| GET | `/users/create` | `users.create` | `UserController@create` | Admin |
| POST | `/users` | `users.store` | `UserController@store` | Admin |
| GET | `/users/{id}/edit` | `users.edit` | `UserController@edit` | Admin |
| PUT/PATCH | `/users/{id}` | `users.update` | `UserController@update` | Admin |
| DELETE | `/users/{id}` | `users.destroy` | `UserController@destroy` | Admin |
| GET | `/teams` | `teams.index` | `TeamController@index` | Admin |
| GET | `/teams/create` | `teams.create` | `TeamController@create` | Admin |
| POST | `/teams` | `teams.store` | `TeamController@store` | Admin |
| GET | `/teams/{id}/edit` | `teams.edit` | `TeamController@edit` | Admin |
| PUT/PATCH | `/teams/{id}` | `teams.update` | `TeamController@update` | Admin |
| DELETE | `/teams/{id}` | `teams.destroy` | `TeamController@destroy` | Admin |
| GET | `/insurance-partners` | `insurance-partners.index` | `InsurancePartnerController@index` | Admin |
| GET | `/insurance-partners/create` | `insurance-partners.create` | `InsurancePartnerController@create` | Admin |
| POST | `/insurance-partners` | `insurance-partners.store` | `InsurancePartnerController@store` | Admin |
| GET | `/insurance-partners/{id}` | `insurance-partners.show` | `InsurancePartnerController@show` | Admin |
| GET | `/insurance-partners/{id}/edit` | `insurance-partners.edit` | `InsurancePartnerController@edit` | Admin |
| PUT/PATCH | `/insurance-partners/{id}` | `insurance-partners.update` | `InsurancePartnerController@update` | Admin |
| DELETE | `/insurance-partners/{id}` | `insurance-partners.destroy` | `InsurancePartnerController@destroy` | Admin |

---

## Matrice d'accès par rôle

| Fonctionnalité | Admin | Lead | Agent Conseil | Agent Terrain | Agent Renouvellement |
|----------------|-------|------|---------------|---------------|----------------------|
| Dashboard | ✓ | ✓ | ✓ | ✓ | ✓ |
| Voir toutes les opps | ✓ | Équipe seul. | Assignées seul. | Créées seul. | Statut Gagné seul. |
| Créer une opp | ✓ | ✓ | ✓ | ✓ | ✓ |
| Modifier une opp | ✓ | ✓ | ✓ | ✓ | Statut Gagné seul. |
| Supprimer une opp | ✓ | ✗ | ✗ | ✗ | ✗ |
| Affecter une opp | ✓ | ✓ |✓ |✗ | ✓|
| Changer statut | ✓ | ✓ | ✓ | ✗ | ✓ |
| Voir clients | ✓ | ✓ | ✓ | ✓ | ✓ |
| Voir contrats | ✓ | ✓ | ✓ | ✓ | ✓ |
| Gérer contrats | ✓ | ✓ | ✓ | ✗ | ✓ |
| Bordereaux | ✓ | ✓ | ✗ | ✗ | ✗ |
| Gérer utilisateurs | ✓ | ✗ | ✗ | ✗ | ✗ |
| Gérer équipes | ✓ | ✗ | ✗ | ✗ | ✗ |
| Gérer partenaires | ✓ | ✗ | ✗ | ✗ | ✗ |

---

## Paramètres de query string acceptés

### `GET /opportunities`

| Paramètre | Type | Description |
|-----------|------|-------------|
| `status_id` | int | Filtre par statut |
| `search` | string | Recherche dans titre, nom, prénom, téléphone, plaque |
| `date_start` | date | Date d'échéance minimum |
| `date_end` | date | Date d'échéance maximum |
| `relance_start` | date | Date de relance minimum |
| `relance_end` | date | Date de relance maximum |

### `GET /bordereaux/conseil` et `/contrats-gagnes`

| Paramètre | Type | Description |
|-----------|------|-------------|
| `date_debut` | date | Début de période (défaut : 1er du mois) |
| `date_fin` | date | Fin de période (défaut : aujourd'hui) |
| `date_specifique` | date | Surcharge les deux précédents pour une journée précise |

### `GET /bordereaux/stats-comparatives`

| Paramètre | Type | Description |
|-----------|------|-------------|
| `p1_debut`, `p1_fin` | date | Période 1 (défaut : mois précédent) |
| `p2_debut`, `p2_fin` | date | Période 2 (défaut : mois actuel) |
