# 🏗️ PATTERN ARCHITECTURAL - MODÈLE STANDARD POUR LES MODULES

**Document de référence:** Établi le 27 Mars 2026  
**Basé sur:** Module Bordereaux implémenté avec succès  
**À appliquer à:** Tous les nouveaux modules à venir

---

## 📋 Vue d'Ensemble du Pattern

```
SIDEBAR
  └─ Un lien vers le module → HUB (index)
      │
      ↓ (Clic utilisateur)
      │
    HUB - Index View (grid de cartes)
      ├─ Carte 1 → Section Détail 1
      ├─ Carte 2 → Section Détail 2
      ├─ Carte 3 → Section Détail 3
      └─ Carte N → Section Détail N
      
    Chaque Section
      ├─ Filtres & Contrôles
      ├─ Statistiques/Overviews
      ├─ Contenu Principal (Tableaux/Graphiques)
      └─ Bouton "Accueil [Module]" → Retour HUB
```

---

## ✅ CHECKLIST COMPLÈTE - Créer un Nouveau Module

### A. CONTROLLER (app/Http/Controllers/NomController.php)

```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NomController extends Controller
{
    // 1. Vue Hub = affiche cartes des sections disponibles
    public function index(Request $request)
    {
        // Vérifier accès
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403);
        }
        return view('nom-module.index');
    }

    // 2. Vue Section 1 = affiche détails
    public function section1(Request $request)
    {
        // Sécurité
        $user = $request->user();
        if (!$user->isLead() && !$user->isAdmin()) {
            abort(403);
        }
        
        // Filtres dates
        $dateDebut = $request->filled('date_debut') 
            ? Carbon::parse($request->date_debut) 
            : Carbon::now()->startOfMonth();
        $dateFin = $request->filled('date_fin') 
            ? Carbon::parse($request->date_fin) 
            : Carbon::now()->endOfDay();
        
        // Récupérer données
        $donnees = []; // Ajouter logique
        
        return view('nom-module.section1', 
            compact('donnees', 'dateDebut', 'dateFin'));
    }

    // 3. Vue Section 2, etc.
    public function section2(Request $request)
    {
        // Même structure...
    }
}
```

**Point-clés:**
- ✅ Middleware de sécurité dans chaque méthode
- ✅ Gestion dates (défauts, plages, dates spécifiques)
- ✅ Logique métier (calculs, agrégations)
- ✅ Retour view avec `compact('data', 'dates')`

---

### B. ROUTES (routes/web.php)

```php
// BLOC ENTIER À COPIER - Adapter le nom du module/controller

Route::middleware(['auth'])->group(function () {
    // NOM_MODULE (Lead et Admin)
    Route::middleware(['role:lead,admin'])->group(function () {
        Route::get('nom-module', [NomController::class, 'index'])
            ->name('nom-module.index');
        Route::get('nom-module/section1', [NomController::class, 'section1'])
            ->name('nom-module.section1');
        Route::get('nom-module/section2', [NomController::class, 'section2'])
            ->name('nom-module.section2');
        // Route::get('nom-module/sectionN', ...) → Ajouter pour chaque section
    });
});
```

**Checklist:**
- ✅ `Route::middleware(['role:lead,admin'])` sur le groupe
- ✅ Naming: `nom-module.index`, `nom-module.section1`, etc.
- ✅ Route `index` SANS suffixe
- ✅ Routes sections avec slugs explicites

---

### C. VIEWS

#### C.1 - HUB INDEX (`resources/views/nom-module/index.blade.php`)

```blade
<x-app-layout>
    <x-slot name="header">Titre du Module</x-slot>

    {{-- Grille de cartes avec sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- CARTE SECTION 1 --}}
        <a href="{{ route('nom-module.section1') }}" 
           class="card hover:shadow-lg transition-shadow cursor-pointer group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center 
                                group-hover:bg-blue-200 transition-colors">
                        <svg class="w-6 h-6 text-blue-600"><!-- ICÔNE --></svg>
                    </div>
                    <span class="badge bg-blue-100 text-blue-700 text-xs">Catégorie</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Section 1</h3>
                <p class="text-sm text-gray-500">Description courte et claire</p>
                <div class="text-xs text-blue-600 font-semibold mt-3 
                            group-hover:translate-x-1 transition-transform">
                    Consulter →
                </div>
            </div>
        </a>

        {{-- CARTE SECTION 2 --}}
        <a href="{{ route('nom-module.section2') }}" 
           class="card hover:shadow-lg transition-shadow cursor-pointer group">
            {{-- Même structure avec couleur différente (green, amber, etc.) --}}
        </a>

        {{-- À VENIR (Placeholder) --}}
        <div class="card opacity-50">
            {{-- Même structure mais sans lien --}}
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="card bg-blue-50 border border-blue-200">
        <div class="card-body">
            <h4 class="font-semibold text-blue-900 mb-1">À propos du module</h4>
            <p class="text-sm text-blue-800">Description générale et instructions</p>
        </div>
    </div>
</x-app-layout>
```

**Règles:**
- Chaque section = 1 carte cliquable
- Couleurs différentes par section (blue, green, amber, pink)
- Hover effect avec ombres
- Badge et icône pour chaque section
- Bouton "À venir" pour sections futures

#### C.2 - SECTION DÉTAIL (`resources/views/nom-module/section1.blade.php`)

```blade
<x-app-layout>
    <x-slot name="header">Titre Section 1</x-slot>

    {{-- RETOUR AU HUB --}}
    <div class="mb-6 flex gap-2">
        <a href="{{ route('nom-module.index') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2"><!-- Icône retour --></svg>
            Accueil [Nom Module]
        </a>
        <div class="badge bg-blue-100 text-blue-700">Section 1</div>
    </div>

    {{-- FILTRES --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Filtres de période</h3>
            <form method="GET" action="{{ route('nom-module.section1') }}" 
                  class="flex gap-4 items-end flex-wrap">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Date début</label>
                    <input type="date" name="date_debut" 
                           value="{{ $dateDebut->format('Y-m-d') }}" 
                           class="form-input w-40">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Date fin</label>
                    <input type="date" name="date_fin" 
                           value="{{ $dateFin->format('Y-m-d') }}" 
                           class="form-input w-40">
                </div>
                <button type="submit" class="btn-primary">Filtrer</button>
                <a href="{{ route('nom-module.section1') }}" class="btn-secondary text-sm">
                    Réinitialiser
                </a>
            </form>
        </div>
    </div>

    {{-- STATISTIQUES (4 cartes) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card">
            <div class="card-body">
                <p class="text-xs font-semibold text-gray-600 uppercase">Métrique 1</p>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $donnees['metrique1'] ?? 0 }}</p>
            </div>
        </div>
        {{-- Répéter pour autres métriques --}}
    </div>

    {{-- CONTENU PRINCIPAL (Table ou Graphique) --}}
    <div class="card">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Résultats</h3>
            {{-- Insertion table, graphique, ou contenu spécifique --}}
        </div>
    </div>

</x-app-layout>
```

---

### D. NAVIGATION (resources/views/layouts/app.blade.php)

```blade
{{-- Ajouter dans la section appropriée du sidebar --}}

@if(auth()->user()->isAdmin() || auth()->user()->isLead())
    <div class="sidebar-section">[Catégorie]</div>
    <a href="{{ route('nom-module.index') }}" 
       class="sidebar-link {{ request()->routeIs('nom-module.*') ? 'active' : '' }}">
        <svg class="w-5 h-5 mr-3">{{-- Icône --}}</svg>
        Nom Module
    </a>
@endif
```

**Règles:**
- ✅ UN SEUL lien dans le sidebar
- ✅ Pointer vers `route('nom-module.index')`
- ✅ Classe active si `routeIs('nom-module.*')`
- ❌ PAS de sous-menus imbriqués

---

## 🎨 COMPOSANTS RÉUTILISABLES

### Carte Statistique Standard

```blade
<div class="card">
    <div class="card-body">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Titre</p>
                <p class="text-3xl font-bold text-primary-600 mt-2">{{ $valeur }}</p>
            </div>
            <svg class="w-8 h-8 text-primary-200">{{-- Icône --}}</svg>
        </div>
    </div>
</div>
```

### Filtre Dates Standard

```blade
<form method="GET" action="{{ route('mon-module.section') }}" class="flex gap-4 items-end flex-wrap">
    <input type="date" name="date_debut" value="{{ $dateDebut->format('Y-m-d') }}" class="form-input">
    <input type="date" name="date_fin" value="{{ $dateFin->format('Y-m-d') }}" class="form-input">
    <button type="submit" class="btn-primary">Filtrer</button>
</form>
```

---

## 📊 EXEMPLE COMPLET - Module Statistiques Avancées

**Structure à créer:**

```
app/Http/Controllers/StatistiquesController.php
routes/web.php (ajouter bloc Route)
resources/views/statistiques/
    ├── index.blade.php (HUB)
    ├── operations-ventes.blade.php (Section 1)
    ├── analyse-produits.blade.php (Section 2)
    └── previsions.blade.php (Section 3)
resources/views/layouts/app.blade.php (ajouter lien)
```

**Route générée:**
- `GET /statistiques` → Hub
- `GET /statistiques/operations-ventes` → Détail
- `GET /statistiques/analyse-produits` → Détail
- `GET /statistiques/previsions` → Détail

---

## ✨ POINTS CLÉS À RETENIR

1. **HUB = Présentateur** - Affiche seulement les cartes des sections
2. **SECTIONS = Détails** - Filtres, statistiques, contenu complet
3. **Sidebar = Minimaliste** - 1 lien par module = accès au hub
4. **Retour facile** - Chaque section a bouton "Accueil [Module]"
5. **Couleurs** - Chaque section sa couleur pour clarté visuelle
6. **Badges** - Indiquent clairement la section active
7. **Dates** - Pattern unifié (date_debut, date_fin, défauts)
8. **Stats** - 4 cartes grid (standard dans tous les modules)

---

## 🎯 VALIDATION - Module Bien Implémenté Si:

- ✅ Sidebar a 1 lien vers le module
- ✅ Clic → Hub avec 3+ cartes
- ✅ Chaque carte → section détail
- ✅ Vue détail a "Accueil [Module]"
- ✅ Pas de sous-menus nulle part
- ✅ Filtres dates identiques à Bordereaux
- ✅ 4 cartes stats au-dessus du contenu
- ✅ Une table OU graphique pour contenu
- ✅ Badges montrant section active
- ✅ Cohérence couleurs & icônes

---

**Version:** 1.0  
**Dernière mise à jour:** 27 Mars 2026  
**Créateur:** Pattern établi via Module Bordereaux  
**Status:** ✅ Approuvé - À utiliser systématiquement
