# Récapitulatif du Projet

Voici un résumé simple des fonctionnalités déjà implémentées sur le projet :

*   **Authentification et UI :** Laravel Breeze est installé avec la stack **Blade** et **Tailwind CSS**. Les pages d'inscription, de connexion et de profil sont fonctionnelles.
*   **Modèles et Relations (Eloquent) :** 
    *   `User` (lié aux commandes et au panier)
    *   `Category` (liée aux produits)
    *   `Product` (lié aux catégories, au panier et aux commandes)
    *   `Order` (lié à l'utilisateur et aux produits achetés)
    *   `CartProduct` (pivot panier avec quantité)
    *   `OrderProduct` (pivot commande figeant le prix et la quantité)
*   **Base de Données et Migrations :**
    *   Les migrations pour les 6 tables initiales ont été configurées (avec contraintes d'intégrité cascade et unique) et exécutées.
    *   Le champ `is_admin` (booléen) a été ajouté à la table `users`.
    *   Une nouvelle migration a été créée et exécutée pour ajouter le champ `barcode` (unique et nullable) à la table `products`.
*   **Packages installés :**
    *   **`spatie/laravel-sluggable`** : Pour générer automatiquement et proprement les slugs d'URL.
    *   **`milon/barcode`** : Pour générer et afficher des codes-barres sur la fiche produit.
    *   **`barryvdh/laravel-dompdf`** : Pour la génération de factures clients en PDF.
    *   **`laravel/cashier`** : Pour l'intégration des fonctionnalités de paiement via la passerelle Stripe.
