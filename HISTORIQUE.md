# CA CRM - Historique du projet

## Description
CRM complet pour un call center vendant des assurances. Gestion des opportunités depuis leur création (Agent Terrain) jusqu'à leur traitement (Agent Conseil), avec supervision (Lead) et administration (Admin).

---

## Environnement technique
- **Framework** : Laravel 9 (v9.x)
- **PHP** : 8.3 (XAMPP)
- **Base de données** : MariaDB 10.4 (XAMPP)
- **Frontend** : Blade + Tailwind CSS (via Laravel Breeze)
- **Build** : Vite 4.5
- **Serveur** : XAMPP Apache
- **URL** : `http://localhost/ca_crm/public`

---

## Session 1 — 18/02/2026 — Création initiale du projet

### Ce qui a été fait :

#### 1. Installation
- `composer create-project laravel/laravel:^9.0`
- `composer require laravel/breeze:^1.0 --dev` + `php artisan breeze:install blade`
- Configuration `.env` : DB `ca_crm`, user `root`, pas de mot de passe
- Création de la base `ca_crm` dans MariaDB
- Build des assets : `npm run build`

#### 2. Base de données — 8 migrations
| Table | Fichier | Description |
|-------|---------|-------------|
| roles | `2024_01_01_000001_create_roles_table.php` | id, name, slug |
| teams | `2024_01_01_000002_create_teams_table.php` | id, name, description |
| users (modif) | `2024_01_01_000003_add_role_team_to_users_table.php` | Ajout role_id, team_id |
| clients | `2024_01_01_000004_create_clients_table.php` | first_name, last_name, email, phone, address, city |
| statuses | `2024_01_01_000005_create_statuses_table.php` | name, slug, order, color |
| opportunities | `2024_01_01_000006_create_opportunities_table.php` | client_id, created_by, assigned_to, status_id, team_id, title, description, source |
| comments | `2024_01_01_000007_create_comments_table.php` | opportunity_id, user_id, body |
| assignments | `2024_01_01_000008_create_assignments_table.php` | opportunity_id, assigned_by, assigned_to |

#### 3. Modèles Eloquent — 8 modèles
| Modèle | Fichier | Relations principales |
|--------|---------|----------------------|
| User | `app/Models/User.php` | belongsTo Role, belongsTo Team, hasMany Opportunity (created/assigned), hasMany Comment. Méthodes : `hasRole()`, `isAdmin()`, `isLead()`, `isAgentConseil()`, `isAgentTerrain()` |
| Role | `app/Models/Role.php` | hasMany User |
| Team | `app/Models/Team.php` | hasMany User, hasMany Opportunity |
| Client | `app/Models/Client.php` | hasMany Opportunity. Accessor : `full_name` |
| Status | `app/Models/Status.php` | hasMany Opportunity |
| Opportunity | `app/Models/Opportunity.php` | belongsTo Client, User (creator/assignee), Status, Team. hasMany Comment, Assignment |
| Comment | `app/Models/Comment.php` | belongsTo Opportunity, User |
| Assignment | `app/Models/Assignment.php` | belongsTo Opportunity, User (assigner/assignee) |

#### 4. Seeders
| Seeder | Données |
|--------|---------|
| `RoleSeeder` | admin, lead, agent_conseil, agent_terrain |
| `StatusSeeder` | Nouveau (#3b82f6), Affecté (#8b5cf6), En cours (#f59e0b), Contacté (#06b6d4), Transformé (#10b981), Perdu (#ef4444) |
| `TeamSeeder` | Équipe Alpha, Équipe Beta |
| `UserSeeder` | 1 admin, 2 leads, 5 agents conseil, 5 agents terrain |
| `OpportunitySeeder` | 50 clients (factory), 30 opportunités avec commentaires et historique d'affectation |

#### 5. Authentification & Autorisation
- **Middleware** `CheckRole` (`app/Http/Middleware/CheckRole.php`) — enregistré comme `role` dans `Kernel.php`
- **OpportunityPolicy** (`app/Policies/OpportunityPolicy.php`) — viewAny, view, create, update, assign, changeStatus, delete
- Enregistré dans `AuthServiceProvider`

#### 6. Controllers — 6 controllers
| Controller | Fichier | Fonctionnalités |
|------------|---------|-----------------|
| DashboardController | `app/Http/Controllers/DashboardController.php` | Dashboard adapté par rôle (stats, tableaux) |
| OpportunityController | `app/Http/Controllers/OpportunityController.php` | CRUD + assign + changeStatus + filtres (search, status) |
| ClientController | `app/Http/Controllers/ClientController.php` | CRUD + recherche |
| UserController | `app/Http/Controllers/UserController.php` | CRUD utilisateurs (admin only) |
| TeamController | `app/Http/Controllers/TeamController.php` | CRUD équipes (admin only) |
| CommentController | `app/Http/Controllers/CommentController.php` | Ajout de commentaires sur opportunités |

#### 7. Routes (`routes/web.php`)
- `/` → redirige vers login
- `/dashboard` → DashboardController (auth)
- `/opportunities` → resource + `POST assign`, `POST status`
- `/opportunities/{id}/comments` → CommentController store
- `/clients` → resource
- `/users` → resource (middleware `role:admin`)
- `/teams` → resource (middleware `role:admin`)
- Routes Breeze (login, register, profile, etc.)

#### 8. Vues Blade — 16 vues
| Dossier | Fichiers |
|---------|----------|
| `layouts/` | `app.blade.php` (layout principal avec sidebar par rôle) |
| `/` | `dashboard.blade.php` (dashboard adaptatif) |
| `opportunities/` | `index.blade.php`, `create.blade.php`, `show.blade.php`, `edit.blade.php` |
| `clients/` | `index.blade.php`, `create.blade.php`, `show.blade.php`, `edit.blade.php` |
| `users/` | `index.blade.php`, `create.blade.php`, `edit.blade.php` |
| `teams/` | `index.blade.php`, `create.blade.php`, `edit.blade.php` |

---

## Comptes de connexion
| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@ca-crm.com | password |
| Lead (Alpha) | lead1@ca-crm.com | password |
| Lead (Beta) | lead2@ca-crm.com | password |
| Agent Conseil | conseil1@ca-crm.com | password |
| Agent Terrain | terrain1@ca-crm.com | password |

---

## Commandes utiles
```bash
# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Builder les assets frontend
npm run build

# Lancer le serveur de dev (alternatif à XAMPP)
php artisan serve

# Vider le cache
php artisan cache:clear && php artisan view:clear && php artisan route:clear
```

---

## Structure des fichiers créés
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ClientController.php
│   │   ├── CommentController.php
│   │   ├── DashboardController.php
│   │   ├── OpportunityController.php
│   │   ├── TeamController.php
│   │   └── UserController.php
│   └── Middleware/
│       └── CheckRole.php
├── Models/
│   ├── Assignment.php
│   ├── Client.php
│   ├── Comment.php
│   ├── Opportunity.php
│   ├── Role.php
│   ├── Status.php
│   ├── Team.php
│   └── User.php (modifié)
├── Policies/
│   └── OpportunityPolicy.php
database/
├── factories/
│   ├── ClientFactory.php
│   └── OpportunityFactory.php
├── migrations/
│   ├── 2024_01_01_000001_create_roles_table.php
│   ├── 2024_01_01_000002_create_teams_table.php
│   ├── 2024_01_01_000003_add_role_team_to_users_table.php
│   ├── 2024_01_01_000004_create_clients_table.php
│   ├── 2024_01_01_000005_create_statuses_table.php
│   ├── 2024_01_01_000006_create_opportunities_table.php
│   ├── 2024_01_01_000007_create_comments_table.php
│   └── 2024_01_01_000008_create_assignments_table.php
├── seeders/
│   ├── DatabaseSeeder.php (modifié)
│   ├── OpportunitySeeder.php
│   ├── RoleSeeder.php
│   ├── StatusSeeder.php
│   ├── TeamSeeder.php
│   └── UserSeeder.php
resources/views/
├── layouts/app.blade.php (remplacé)
├── dashboard.blade.php (remplacé)
├── opportunities/ (index, create, show, edit)
├── clients/ (index, create, show, edit)
├── users/ (index, create, edit)
└── teams/ (index, create, edit)
routes/
└── web.php (remplacé)
```
