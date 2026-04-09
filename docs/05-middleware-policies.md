# Middleware et Policies d'autorisation

Ce fichier documente les deux mécanismes de contrôle d'accès de l'application : le middleware `CheckRole` (protection des routes) et les Policies Eloquent (autorisations fines par action).

---

## Middleware CheckRole

**Fichier :** `app/Http/Middleware/CheckRole.php`  
**Alias enregistré :** `role` (dans `app/Http/Kernel.php`)

### Fonctionnement

```php
public function handle(Request $request, Closure $next, ...$roles)
{
    if (!$request->user() || !$request->user()->hasAnyRole($roles)) {
        abort(403, 'Accès non autorisé.');
    }
    return $next($request);
}
```

Le middleware accepte un ou plusieurs slugs de rôles en paramètres. Il appelle `User::hasAnyRole()` pour vérifier que l'utilisateur possède au moins un des rôles listés.

### Usage dans les routes

```php
// Un seul rôle
Route::middleware(['role:admin'])->group(function () { ... });

// Plusieurs rôles acceptés
Route::middleware(['role:lead,admin'])->group(function () { ... });
```

### Comportement en cas d'échec

Retourne une réponse HTTP 403 avec le message "Accès non autorisé." Laravel rend la vue d'erreur `errors/403.blade.php` si elle existe, sinon la page d'erreur par défaut.

---

## Policies Eloquent

Les policies sont enregistrées dans `app/Providers/AuthServiceProvider.php` et contrôlent les actions sur des modèles spécifiques. Elles sont invoquées via `$this->authorize()` dans les contrôleurs.

### OpportunityPolicy

**Fichier :** `app/Policies/OpportunityPolicy.php`  
**Modèle :** `Opportunity`

| Méthode | Qui peut ? | Règle détaillée |
|---------|-----------|-----------------|
| `viewAny` | Tous | Retourne toujours `true` (le filtrage se fait dans le contrôleur) |
| `view` | Tous les rôles nommés | Admin, Lead, Agent Conseil, Agent Terrain, Agent Renouvellement → `true`. Agent Renouvellement ne voit en théorie que les opportunités `gagne` (doublon de code non encore nettoyé) |
| `create` | Admin, Lead, Agent Conseil, Agent Terrain, Agent Renouvellement | Tout rôle nommé peut créer |
| `update` | Admin, Lead, Agent Conseil, Agent Terrain | Toujours `true` pour ces rôles. Agent Renouvellement : uniquement si statut = `gagne`. Sinon : seulement si `assigned_to = user->id` |
| `assign` | Admin, Lead | Seuls Admin et Lead peuvent affecter une opportunité à un conseiller |
| `changeStatus` | Admin, Lead, Agent Conseil (assigné) | Agent Renouvellement ne peut jamais changer le statut. Agent Conseil : seulement si `assigned_to = user->id` |
| `delete` | Admin | Uniquement l'admin peut supprimer |

**Appels dans le contrôleur :**
```php
$this->authorize('create', Opportunity::class);  // pas d'instance
$this->authorize('view', $opportunity);           // avec instance
$this->authorize('assign', $opportunity);
$this->authorize('changeStatus', $opportunity);
$this->authorize('delete', $opportunity);
```

---

### ContractPolicy

**Fichier :** `app/Policies/ContractPolicy.php`  
**Modèle :** `Contract`

| Méthode | Accès autorisé |
|---------|----------------|
| `viewAny` | Tous les rôles authentifiés |
| `view` | Tous les rôles authentifiés |
| `create` | Admin, Lead, Agent Conseil, Agent Renouvellement |
| `update` | Admin, Lead, Agent Conseil, Agent Renouvellement |
| `delete` | Admin uniquement |

---

### InsurancePartnerPolicy

**Fichier :** `app/Policies/InsurancePartnerPolicy.php`  
**Modèle :** `InsurancePartner`

| Méthode | Accès autorisé |
|---------|----------------|
| `viewAny` | Admin uniquement |
| `view` | Admin uniquement |
| `create` | Admin uniquement |
| `update` | Admin uniquement |
| `delete` | Admin uniquement |

> Ces vérifications sont redondantes avec le middleware `role:admin` sur les routes, mais assurent une double protection.

---

## Résumé des couches de sécurité

L'application utilise deux niveaux d'autorisation complémentaires :

```
Requête HTTP
    │
    ▼
[Middleware auth]          → Vérifie que l'utilisateur est connecté
    │
    ▼
[Middleware role:xxx]      → Vérifie le rôle pour certains groupes de routes
    │                         (admin, lead+admin)
    ▼
[Controller]               → Appelle $this->authorize() via la Policy
    │                         pour des vérifications contextuelles
    ▼
[Policy]                   → Vérifie si l'utilisateur peut effectuer
                              l'action sur cette instance précise du modèle
```

### Exemple : accès à `PUT /opportunities/{id}`

1. `middleware('auth')` → utilisateur connecté ? ✓
2. Pas de middleware `role` sur cette route
3. `$this->authorize('update', $opportunity)` → `OpportunityPolicy::update` :
   - Admin/Lead/Agent Conseil/Agent Terrain → ✓
   - Agent Renouvellement → ✓ uniquement si `opportunity.status.slug === 'gagne'`
   - Autre → `assigned_to === user->id` ?

---

## Gestion du filtrage dans les contrôleurs

En complément des policies, l'`OpportunityController` applique un **filtrage des données au niveau des requêtes** :

```php
// Agent Conseil : ne voit que ses opportunités assignées
$query->where('assigned_to', $user->id);

// Agent Terrain : ne voit que ses opportunités créées
$query->where('created_by', $user->id);

// Lead : ne voit que les opportunités de son équipe
$query->where('team_id', $user->team_id);
```

Ce filtrage s'applique à `index()`, `getGroupCounts()`, et aux stats du dashboard.

---

## Méthodes de vérification de rôle (User model)

Ces méthodes sont utilisées dans toute l'application (contrôleurs, vues, policies) :

```php
$user->hasRole('admin')          // rôle exact
$user->hasAnyRole(['admin', 'lead'])  // l'un des rôles listés
$user->isAdmin()                 // raccourci hasRole('admin')
$user->isLead()                  // raccourci hasRole('lead')
$user->isAgentConseil()          // raccourci hasRole('agent_conseil')
$user->isAgentTerrain()          // raccourci hasRole('agent_terrain')
$user->isAgentConseilRenouvellement()  // raccourci hasRole('agent_conseil_renouvellement')
```
