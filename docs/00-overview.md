# CA CRM — Vue d'ensemble du projet

## Présentation

CA CRM est une application web de gestion de la relation client (CRM) dédiée aux équipes commerciales d'un call center d'assurances. Elle couvre le cycle complet d'une opportunité : de la prospection terrain jusqu'à la signature du contrat et le suivi des renouvellements.

**Stack technique :**
- Framework : Laravel 9
- Authentification : Laravel Breeze (sessions)
- Frontend : Blade + Tailwind CSS + Alpine.js
- Base de données : MariaDB 10.4 (via XAMPP)
- Build assets : Vite 4.5
- URL locale : `http://localhost/ca_crm/public`

---

## Rôles utilisateurs

L'application définit 5 rôles stockés en base (`roles.slug`) :

| Slug | Nom affiché | Description |
|------|-------------|-------------|
| `admin` | Administrateur | Accès total, gestion des utilisateurs/équipes/partenaires |
| `lead` | Lead / Manager | Gestion de son équipe, bordereaux, affectation des opportunités |
| `agent_terrain` | Agent Terrain | Crée des opportunités sur le terrain |
| `agent_conseil` | Agent Conseil | Traite les opportunités qui lui sont affectées |
| `agent_conseil_renouvellement` | Agent Renouvellement | Gère les contrats existants à renouveler |

---

## Statuts d'une opportunité

Les statuts sont stockés en base (`statuses.slug`) et ordonnés par `order` :

| Slug | Libellé | Signification |
|------|---------|---------------|
| `nouvelle` | Nouvelle | Opportunité créée, non encore affectée à un conseil |
| `rendez_vous` | Rendez-vous | Opportunité affectée à un agent conseil |
| `poursuivre` | Poursuivre | En cours de traitement |
| `gagne` | Gagné | Contrat signé — crée automatiquement un Client et un Contract |
| `perdus` | Perdus | Opportunité perdue |
| `reporter` | Reporter | À relancer ultérieurement |

---

## Architecture de l'application

```
ca_crm/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Contrôleurs métier + Auth + API
│   │   └── Middleware/
│   │       └── CheckRole.php     # Garde les routes par rôle
│   ├── Models/                   # Modèles Eloquent
│   └── Policies/                 # Autorisations fines (OpportunityPolicy, ContractPolicy…)
├── database/
│   ├── migrations/               # Migrations incrémentales
│   └── seeders/                  # Ordre : Role → Status → Team → User → Opportunity
├── resources/views/              # Vues Blade organisées par module
├── routes/
│   ├── web.php                   # Routes web authentifiées
│   └── auth.php                  # Routes Breeze (login, register…)
└── public/storage/               # Fichiers uploadés (cartes grises, attestations…)
```

---

## Flux principal d'une opportunité

```
[Agent Terrain]
    └── Crée une opportunité (statut: Nouvelle)
            │
[Lead / Admin]
    └── Affecte l'opportunité à un Agent Conseil (statut: Rendez-vous)
            │ Assignment créé en base
            │
[Agent Conseil]
    └── Traite l'opportunité (Poursuivre / Reporter / Perdus)
            │
            └── Statut → Gagné
                    ├── Client créé automatiquement (si nouveau)
                    └── Contrat créé automatiquement (si assureur_actuel correspond à un InsurancePartner)
```

---

## Modèle de données — Relations principales

```
Role ──< User >── Team
                   │
User ──< Opportunity >── Status
         │    │    └── InsurancePartner
         │    ├──< Assignment >── User (assigned_to)
         │    ├──< Comment >── User
         │    └──< Contract >── InsurancePartner
         │                  └── Client
         └── Client ──< Opportunity
```

---

## Commandes utiles (développement)

```bash
# Démarrer XAMPP (Apache + MySQL)
# Puis :

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install

# Compiler les assets
npm run build

# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Créer le lien symbolique pour le stockage
php artisan storage:link
```

---

## Fichiers de configuration clés

| Fichier | Rôle |
|---------|------|
| `.env` | Variables d'environnement (DB, APP_URL, etc.) |
| `config/auth.php` | Garde d'authentification |
| `app/Http/Kernel.php` | Enregistrement du middleware `role` |
| `app/Providers/AuthServiceProvider.php` | Enregistrement des Policies |
