# Documentation CA CRM

Documentation technique complète du projet CA CRM — CRM call center pour la gestion d'opportunités d'assurance.

## Fichiers

| Fichier | Contenu |
|---------|---------|
| [00-overview.md](./00-overview.md) | Vue d'ensemble, stack technique, rôles, statuts, architecture, flux métier |
| [01-models.md](./01-models.md) | Tous les modèles Eloquent (champs, relations, méthodes) |
| [02-controllers.md](./02-controllers.md) | Tous les contrôleurs (méthodes, logique métier, autorisations) |
| [03-views.md](./03-views.md) | Toutes les vues Blade (fonctionnel + technique) |
| [04-routes.md](./04-routes.md) | Table des routes avec accès par rôle et paramètres |
| [05-middleware-policies.md](./05-middleware-policies.md) | Middleware CheckRole et Policies d'autorisation |

## Démarrage rapide pour un nouveau développeur

1. Lire **00-overview.md** pour comprendre l'architecture globale et le flux métier
2. Lire **01-models.md** pour comprendre le schéma de données
3. Lire **04-routes.md** pour avoir une vue d'ensemble des fonctionnalités
4. Consulter **02-controllers.md** et **03-views.md** pour plonger dans une fonctionnalité spécifique
5. Consulter **05-middleware-policies.md** avant de toucher aux autorisations
