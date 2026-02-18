Agis comme un Architecte Logiciel Senior spécialisé en Laravel.

Contexte :
Je souhaite concevoir un CRM pour un call center qui vend des assurances.
L’objectif est de gérer des opportunités commerciales depuis leur création jusqu’à leur traitement par les équipes.

Stack technique :
- Backend : Laravel (version 9)
- Frontend : Blades
- Base de données : MySQL
- Utiliser des données mockées (seeders/factories)
- Authentification Laravel standard (Breeze ou équivalent)

Domaines métier :

1. Types d’utilisateurs (rôles)

- Agent Terrain
  - Crée des opportunités (prospects)
  - Associe les informations client

- Agent Conseil
  - Traite les opportunités qui lui sont affectées
  - Met à jour le statut (en cours, contacté, transformé, perdu)
  - Ajoute des commentaires / suivi

- Lead d’équipe
  - Voit toutes les opportunités de son équipe
  - Affecte les opportunités aux Agents Conseil
  - Suit la performance et l’avancement des membres

- Administrateur Général
  - Crée et gère les utilisateurs
  - Gère les rôles et profils
  - Crée des groupes/équipes
  - Ajoute des membres aux groupes
  - Peut voir et affecter toutes les opportunités

2. Entités principales

- User
- Role
- Team / Groupe
- Opportunity
- Client
- Comment / Historique
- Assignment (affectation)
- Status (pipeline)

3. Statuts possibles pour une opportunité

- Nouveau
- Affecté
- En cours
- Contacté
- Transformé
- Perdu

Fonctionnalités principales :

- Authentification et gestion des rôles (RBAC)
- Création d’opportunités par les Agents Terrain
- Affectation d’opportunités par Lead ou Admin
- Gestion du pipeline par Agent Conseil
- Historique des actions sur chaque opportunité
- Tableau de bord par rôle :
  - Agent Conseil : ses opportunités
  - Lead : opportunités de son équipe + statistiques
  - Admin : vue globale

Contraintes techniques :

- Utiliser les bonnes pratiques Laravel :
  - MVC propre
  - Policies pour les permissions
  - Form Requests pour la validation
  - Factories + Seeders pour données mockées
- Fournir :
  - Migrations
  - Modèles et relations Eloquent
  - Controllers principaux
  - Routes
  - Seeders de démonstration
  - Exemples de vues simples (Blade ou Vue)

Livrables attendus :

1. Architecture du projet (structure des dossiers)
2. Schéma de base de données (tables et relations)
3. Migrations Laravel
4. Modèles avec relations
5. Seeders avec données mockées :
   - utilisateurs par rôle
   - équipes
   - opportunités
6. Exemple de flux :
   - création d’une opportunité
   - affectation
   - traitement
7. Propositions d’amélioration (scalabilité, évolutions futures)

Important :
- Code clair et prêt à être exécuté
- Explications concises mais professionnelles
- Prioriser la simplicité et la maintenabilité