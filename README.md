<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Projet Laravel E-commerce - ESGI 3ème Année

Ce dépôt contient notre projet Laravel 11 de fin de module. L'objectif est de concevoir une application web e-commerce complète avec une base de données relationnelle robuste, des fonctionnalités avancées et un back-office d'administration sécurisé.

---

## Conformité avec le sujet (Critères d'évaluation)

Notre projet répond en tous points aux critères d'évaluation requis pour la soutenance :

*   **Modèle de base de données relationnelle (Eloquent ORM) :** Utilisation intensive de relations complexes :
    *   *One-to-Many* : Catégorie ➔ Produits, Utilisateur ➔ Commandes.
    *   *Many-to-Many avec tables pivots* : Panier de l'utilisateur (`cart_product`) et Lignes de commandes figeant le prix à l'achat (`order_product`).
*   **CRUD complets & Sécurisés :** Gestion complète (création, lecture, modification, suppression) des produits (avec stockage d'image) et des catégories dans un espace administration.
*   **Données de test réalistes (Seeders & Factories) :** Remplissage automatique de la base via un Seeder en français avec 1 compte administrateur fixe (`admin@example.com`), 5 comptes clients de test, 5 catégories réalistes et 30 produits avec stock, prix, description et codes-barres uniques.
*   **Sécurisation :** Utilisation d'un middleware personnalisé `AdminMiddleware` protégeant les routes `/admin/*`.
*   **Validation des données (Form Requests) :** Validation stricte de tous les formulaires (unicité du code-barres à la création/modification, formats d'images autorisés, adresses valides).
*   **Intégration d'API externe (data.gouv.fr) :** Autocomplétion dynamique d'adresse postale réelle en temps réel sur la page de validation de commande via l'API Adresse publique de l'État.

---

## Fonctionnalités Majeures de l'Application

### Côté Client (Catalogue & Commande)
*   **Catalogue Public :** Recherche par filtre de catégorie, affichage dynamique et fiches produits détaillées.
*   **Rendu des Codes-barres :** Chaque fiche produit affiche le code-barres unique associé au produit (généré en format vectoriel SVG).
*   **URLs propres (SEO) :** Utilisation des **Slugs** à la place des IDs dans toutes les URLs publiques des produits et catégories.
*   **Panier persistant :** Les paniers sont stockés en base de données, permettant à l'utilisateur de retrouver ses articles d'une session à l'autre.
*   **Processus d'achat (Checkout) :** Formulaire de livraison avec autocomplétion d'adresse d'après l'API BAN (Base Adresse Nationale). Lors de la validation, le prix d'achat unitaire et la quantité sont figés historiquement dans la table de commande.

### Côté Administration (Back-Office)
*   **Gestion du catalogue :** CRUD complet des produits (avec téléversement et remplacement d'image dans le Storage local) et des catégories.
*   **Suivi des commandes :** Index récapitulatif des commandes passées et fiche détaillée de commande (coordonnées clients, produits achetés au prix d'époque et adresse de livraison complète).

---

## Librairies & Packages Utilisés

*   **`laravel/breeze`** : Système d'authentification utilisateur robuste (Login, Enregistrement, Profil).
*   **`spatie/laravel-sluggable`** : Génération et unicité automatiques des slugs des produits et catégories.
*   **`milon/barcode`** : Rendu graphique des codes-barres en SVG.
*   **`stripe/stripe-php`** : SDK officiel installé pour l'intégration de la passerelle de paiement.
*   **`pestphp/pest`** : Suite de tests automatiques.

---

## Tests de Non-Régression
L'application contient une suite de **50 tests fonctionnels et unitaires** validant la sécurité des accès, la logique de panier, les validations de formulaires et l'autonomie du back-office.

Pour exécuter les tests :
```bash
./vendor/bin/sail artisan test
```
