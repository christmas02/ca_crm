# Documentation Module Bordereaux

**Date:** 27 Mars 2026  
**Objectif:** Module de reporting pour Lead et Admin - Métriques de performance des conseillers

---

## 📋 Actions Effectuées

### 1. Création de la Structure de Base
- ✅ Route `/bordereaux` → `BordereauController@index`
- ✅ Route `/bordereaux/conseil` → `BordereauController@conseil`
- ✅ Middleware de sécurité: `['role:lead,admin']`
- ✅ Navigation sidebar intégrée pour "Reporting"

### 2. Vue Conseil (conseil.blade.php)
- ✅ Filtres de date (date_debut, date_fin, date_specifique)
- ✅ Table avec 8 colonnes de métriques
- ✅ 4 cartes statistiques (count, total, avg conversion, avg score)
- ✅ 2 graphiques Chart.js (conversion rate, opportunités gagnées)

### 3. Calcul des Métriques (BordereauController)
**6 Métrics principales implémentées:**

#### a) OPP. DU JOUR
- **Définition:** Assignations ACTIVES du conseiller pendant la période
- **Requête:** `Assignment::where('assigned_to', id)->where('status', 'active')->whereBetween('date_affect', [debut, fin])`
- **Résultat:** Nombre unique d'opportunités
- **Status:** ✅ Complété

#### b) OPP. MODIFIÉES/COMMENTÉES
- **Définition:** Opportunités où le conseiller a commenté pendant la période
- **Requête:** `Opportunity::where('assigned_to', id)->whereHas('comments', where user_id=id AND whereBetween created_at)`
- **Résultat:** Compte les opportunités avec activité du conseiller
- **Status:** ✅ Complété (Option 2: commentaires du conseiller uniquement)

#### c) TOTAL RENOUVELLEMENT
- **Définition:** Contrats du conseiller avec `contract_number` format `CTR-XXXXX-%`
- **Requête:** `Contract::where('created_by', id)->where('contract_number', 'LIKE', 'CTR-%-%')->whereBetween('created_at', [debut, fin])->whereHas('opportunity', status='gagne')`
- **Résultat:** Compte les contrats renouvelés
- **Status:** ✅ Complété

#### d) OPP. GAGNÉES
- **Définition:** Contrats du conseiller avec `contract_number` format `CTR-XXXXX` (sans renouvellement)
- **Requête:** `Contract::where('created_by', id)->where('contract_number', 'LIKE', 'CTR-%')->whereBetween('created_at', [debut, fin])->whereHas('opportunity', status='gagne')`
- **Résultat:** Compte les nouveaux contrats gagnés
- **Status:** ✅ Complété

#### e) TOTAL OPPORTUNITÉS AFFECTÉES
- **Définition:** Opportunités assignées au conseiller pendant la période
- **Requête:** Double logique - directement assignées (created_at dans période) OU via assignments table (date_affect dans période)
- **Résultat:** Nombre unique d'opportunités traitées
- **Status:** ✅ Complété

#### f) TAUX DE CONVERSION
- **Formule:** `(opp_gagnees / total_opp_affectees) × 100`
- **Protection:** Gestion division par zéro
- **Status:** ✅ Complété

#### g) SCORE
- **Formule simplifiée:** `(total_renouvellement / 3) + contrats_nouveaux`
- **Logique:**
  - Chaque contrat renouvelé = 1/3 point (besoin de 3 pour 1 point)
  - Chaque nouveau contrat = 1 point
- **Exemple:** 6 renouvelés + 2 nouveaux = (6/3) + 2 = 4 points
- **Status:** ✅ Complété

---

## 🔧 Corrections SQL Appliquées

### Issue 1: `distinct()` MariaDB Incompatible
**Erreur:** `Unknown column 'DISTINCT opportunities.id' in 'field list'`
- **Cause:** MariaDB n'accepte pas `distinct()` avec `count()` sur joins
- **Solution:** Changé vers `pluck('opportunity_id')->unique()->count()`
- **Status:** ✅ Résolu

### Issue 2: Colonnes Ambigües dans WHERE
**Erreur:** `Column 'assigned_to' in where clause is ambiguous`
- **Cause:** Joins sans qualification des colonnes
- **Solution:** Utiliser `assignments.assigned_to`, `opportunities.assigned_to`
- **Status:** ✅ Résolu

### Issue 3: Format Contract Number
**Logique:** Distinction entre renouvellement et nouveaux contrats
- Format renouvellement: `CTR-XXXXX-N` (où N = nombre de renouvellements)
- Format nouveau: `CTR-XXXXX`
- **Implémentation:** Patterns LIKE pour distinction
- **Status:** ✅ Résolu

---

## 📊 Filtrage de Dates

**3 Options de filtrage:**
1. **Plage de dates:** `date_debut` + `date_fin`
2. **Date spécifique:** `date_specifique` (convertie en startOfDay → endOfDay)
3. **Défaut:** Mois courant (startOfMonth → now)

**Logique:** Si `date_specifique` fournie = ignorée date_debut/date_fin

---

## 🗂️ Structure de Données

### Table: assignments
- `id` - PK
- `assigned_to` - FK User
- `opportunity_id` - FK Opportunity
- `date_affect` - DateTime de l'assignation
- `status` - active/inactive
- `created_at` / `updated_at`

### Table: contracts
- `id` - PK
- `opportunity_id` - FK Opportunity
- `contract_number` - Format CTR-XXXXX ou CTR-XXXXX-N
- `created_by` - FK User (conseiller créateur)
- `created_at` / `updated_at`

### Table: opportunities
- `id` - PK
- `assigned_to` - FK User (conseiller actuel)
- `status_id` - FK Status
- `created_at` / `updated_at`

### Table: comments
- `id` - PK
- `opportunity_id` - FK Opportunity
- `user_id` - FK User (auteur du commentaire)
- `created_at` / `updated_at`

---

## ⚙️ Configuration

### Rôles Autorisés
- `agent_conseil`
- `agent_conseil_renouvellement`

### Statuts Utilisés
- `gagne` - Slug du statut gagné
- `renouvellement` - OBSOLÈTE (ancienne logique)

### Middleware
```php
Route::middleware(['role:lead,admin'])->group(function () {
    Route::get('/bordereaux', [BordereauController::class, 'index'])->name('bordereaux.index');
    Route::get('/bordereaux/conseil', [BordereauController::class, 'conseil'])->name('bordereaux.conseil');
});
```

---

## 🧪 Tests Nécessaires (À FAIRE)

- [ ] Exécuter seeder: `php artisan db:seed --class=BordereauTestDataSeeder`
- [ ] Vérifier affichage `/bordereaux/conseil`
- [ ] Filtrer par plage de dates
- [ ] Filtrer par date spécifique
- [ ] Vérifier calcul des 6 métriques
- [ ] Vérifier calcul du score
- [ ] Vérifier graphiques Chart.js
- [ ] Tester cas limite (aucune donnée, division par zéro)

---

## 📝 Notes Importantes

### Point Critique: Status='active' sur Assignments
⚠️ **À IMPLÉMENTER:**
- Actuellement: `->where('status', 'active')` sur $opp_jour
- **Problème:** Bloque les données historiques (opportunités réassignées)
- **Proposé:** Supprimer le filtre status pour compter toutes les assignations dans la période

### Éléments Historiques
- Table `assignments` historise les changements d'assignation
- `date_affect` capture quand l'opportunité a été assignée
- Les opportunités réassignées gardent leur historique

---

## 📂 Fichiers Modifiés

1. **app/Http/Controllers/BordereauController.php**
   - Classe: `BordereauController`
   - Méthodes: `index()`, `conseil()`, `calculerMetriques()`

2. **resources/views/bordereaux/conseil.blade.php**
   - Vue du dashboard
   - Filtres, table, graphiques

3. **routes/web.php**
   - Routes `/bordereaux` et `/bordereaux/conseil`

4. **resources/views/layouts/app.blade.php**
   - Section "Reporting" dans sidebar

---

## 🎯 Prochaines Étapes

1. **Résoudre seeder (Exit Code 1)** - À investiguer
2. **Implémenter correction status='active'** - Pour historique complet
3. **Tester avec données réelles** - Valider tous les calculs
4. **Ajuster formules si nécessaire** - Basé sur résultats tests
5. **Documenter cas d'usage** - Pour utilisateurs Lead/Admin

---

**Statut Global:** 🔶 En cours - Logique complète, tests en attente
