# Project Navigate Api

Pour développer une API gérant un ensemble de cartes de transport en désordre,

User story
En tant qu' utilisateur,
Je veux pouvoir avoir l'itinéraire d'un point A vers un point B
Afin que je puisse voir l'ordre complet des transports .

# Liste des Fonctions du Service :

- une fonction pour identifier le point de départ de l'itineraire
- une fonction pour récupérer la prochaine ville dans l'itinéraire.
- une fonction pour créer l'itinéraire en utilisant les deux fonctions précédentes.

# Tests Unitaires :

# Écrire et exécuter des tests unitaires pour les trois fonctions.

- [] Assurer la couverture de tous les cas possibles.
  - [] Un itineraire doit avoir des données valide.
  - [] Un itineraire peux ne pas avoir de données.
- [] Un itineraire peux de mauvaise donnée.
- [] Gestion des Erreurs lorsque l'itineraires est invalid
- [] Les tests doivent etre faux car pas d'algorithme sous-jacent

# Développer l'algorithme sous-jacent pour les services.

Valider les tests unitaires en utilisant l'algorithme des services.

# Tâches de Développement du Contrôleur

- Le Controller va devoir appellée recuperer la collections les itineraires avec leurs differentes stepet il va utiliser le service precedant trier les étapes et definir une itineraire.

- [] Créer le contrôleur en intégrant le Itinary service , la recuperation des datas et les services développés.
- - [] Crée le Model Step
- [] Crée la Collection Itineraire

# Réaliser des tests d'intégration pour le contrôleur.

- [] S'assurer que le contrôleur fonctionne comme prévu avec les services intégrés.

# Autres Features

pour plus tard Possibilité de definir une route et CRUD
