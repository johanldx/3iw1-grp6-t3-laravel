# Spécifications Fonctionnelles & Plan de Charge du Projet E-commerce

Ce document définit la feuille de route technique et la répartition des tâches pour le développement de l'application e-commerce sous Laravel.

Afin d'assurer une collaboration fluide, d'éviter les conflits de fusion (merge conflicts) lors de l'intégration Git et d'équilibrer la charge de développement, le projet est découpé en trois périmètres techniques bien distincts.

---

## 💻 DÉVELOPPEUR A : Catalogue, Référentiel Données & Administration

**Périmètre technique :** Modélisation et peuplement des données, sécurisation des accès administratifs, gestion du catalogue (CRUD) et affichage public.

### 1. Initialisation, Données & Automatisation
*   **Génération des Slugs (`spatie/laravel-sluggable`) :**
    *   Implémenter le trait et configurer la méthode `getSlugOptions()` sur les modèles `Category` et `Product` pour automatiser la création des slugs à partir du nom.
*   **Données de Test (Factories & Seeders) :**
    *   Concevoir les classes `CategoryFactory` et `ProductFactory` à l'aide de la bibliothèque **Faker**.
    *   Configurer `DatabaseSeeder.php` pour instancier un jeu de données de test complet :
        *   1 compte administrateur fixe (`admin@example.com`).
        *   5 comptes utilisateurs (clients).
        *   5 catégories de produits.
        *   30 produits disposant de prix, stocks, descriptions et codes-barres valides.

### 2. Back-Office d'Administration (CRUD)
*   **Sécurisation par Middleware :**
    *   Développer un middleware de sécurité **`AdminMiddleware`** vérifiant la propriété `is_admin === true` de l'utilisateur connecté.
    *   L'enregistrer au niveau de l'application (`bootstrap/app.php`) afin de restreindre l'accès à la route `/admin/*`.
*   **Contrôleurs Administratifs :**
    *   Créer les contrôleurs `AdminCategoryController` et `AdminProductController` pour gérer l'intégralité du cycle de vie des produits et des catégories.
    *   Implémenter des classes de validation dédiées (**Form Requests**) pour valider les données soumises (ex. : unicité du code-barres, prix positif, format d'image).
*   **Interface d'Administration (Vues Blade) :**
    *   Créer les formulaires de gestion dans `resources/views/admin/` (gestion du stockage physique des images téléchargées avec le Storage de Laravel).

### 3. Catalogue Public & Rendu Visuel
*   **Rendu des Codes-barres :**
    *   Intégrer le package **`milon/barcode`** afin de générer l'affichage graphique des codes-barres sur les produits.
*   **Affichage Client :**
    *   Créer le contrôleur public `ProductController` :
        *   `index()` : Affichage paginé des produits avec filtres par catégorie.
        *   `show(Product $product)` : Fiche produit détaillée affichant les informations ainsi que le code-barres généré graphiquement (ex. : `{!! DNS1D::getBarcodeSVG($product->barcode, 'C128') !!}`).
    *   Concevoir les vues associées dans `resources/views/products/`.

---

## 🛒 DÉVELOPPEUR B : Logique Panier & Tunnel de Commande

**Périmètre technique :** Gestion de la persistance du panier en base de données, application des règles métier de gestion de stock, et validation du processus d'achat (checkout).

### 1. Gestion du Panier Persistant (Base de Données)
*   **Persistance Relationnelle :**
    *   Exploiter la relation Many-to-Many configurée entre les modèles `User` et `Product` via la table pivot `cart_product`.
*   **Logique du Contrôleur de Panier (`CartController`) :**
    *   `index()` : Afficher la liste des produits présents dans le panier de l'utilisateur authentifié et calculer le montant total.
    *   `add(Product $product)` : Ajouter un produit au panier ou incrémenter sa quantité si le produit y figure déjà.
    *   `update(Product $product, Request $request)` : Modifier la quantité de l'article en appliquant une validation stricte vis-à-vis du stock disponible (`$product->stock`).
    *   `remove(Product $product)` : Supprimer l'association du produit avec le panier de l'utilisateur (`detach()`).
*   **Interface Panier (Vue Blade) :**
    *   Développer `resources/views/cart/index.blade.php` : tableau récapitulatif interactif, formulaire de mise à jour des quantités et redirection vers le tunnel d'achat.

### 2. Tunnel de Commande (Checkout)
*   **Contrôleur de Validation (`CheckoutController`) :**
    *   `index()` : Afficher le récapitulatif avant paiement et récolter l'adresse de livraison.
*   **Validation des Données d'Achat :**
    *   Créer une classe de validation **`StoreOrderRequest`** (Form Request) chargée de vérifier la validité de l'adresse de livraison et des données client.
*   **Interface Checkout (Vue Blade) :**
    *   Créer la vue `resources/views/checkout/index.blade.php`. *(Cette vue servira de conteneur pour l'intégration de la solution de paiement sécurisé).*

---

## 💳 DÉVELOPPEUR C : Tunnel de Paiement, Traitements Webhooks & Facturation

**Périmètre technique :** Intégration de la passerelle Stripe, automatisation des processus post-paiement (déstockage, vidage du panier), historique utilisateur et génération de factures PDF.

### 1. Tunnel de Paiement Stripe
*   **Configuration de la Passerelle :**
    *   Installer et configurer **Laravel Cashier** (ou le SDK Stripe standard) et renseigner les clés d'API sécurisées dans `.env`.
*   **Intégration Frontend :**
    *   Intégrer Stripe.js et l'élément sécurisé de saisie bancaire (Stripe Elements) au sein de la page de checkout (`checkout.index`).
*   **Création de la Commande (Contrôleur) :**
    *   Lors de l'initiation du paiement, créer un enregistrement dans la table `orders` avec l'état `pending` (en attente).
    *   Copier l'état actuel du panier vers la table pivot `order_product` afin de figer historiquement le prix unitaire et la quantité achetée.

### 2. Traitements Asynchrones & Webhooks Stripe
*   **Gestion des Événements Stripe :**
    *   Développer un contrôleur dédié à la réception du webhook Stripe pour écouter l'événement `payment_intent.succeeded`.
    *   À la réception du paiement confirmé :
        1.  Mettre à jour le statut de la commande concernée à `paid` (payée).
        2.  Mettre à jour les stocks de la table `products` en déduisant les quantités achetées.
        3.  Purger le panier de l'utilisateur dans la table `cart_product`.

### 3. Espace Client & Factures PDF
*   **Historique d'Achat :**
    *   Développer `OrderController` et la vue client `resources/views/orders/index.blade.php` pour lister les commandes de l'utilisateur connecté et leur statut d'expédition.
*   **Génération des Factures PDF :**
    *   Installer et configurer **`barryvdh/laravel-dompdf`**.
    *   Concevoir le gabarit d'impression HTML dans `resources/views/invoices/pdf.blade.php`.
    *   Créer la méthode `downloadInvoice(Order $order)` en appliquant une règle de sécurité stricte (ex. : via une Policy) afin d'interdire le téléchargement d'une facture par un tiers.

---

## 💡 Rationale : Organisation Collaborative & Avantages Pédagogiques

1.  **Isolation des commits & Prévention des conflits :** Le cloisonnement logique par fichier limite la modification simultanée des mêmes fichiers. Le Développeur A intervient sur les fichiers d'administration, le Développeur B sur les cinématiques de panier, et le Développeur C sur les fonctionnalités de facturation et de paiement.
2.  **Équilibre de la charge technique :** Le travail est équitablement réparti entre la modélisation CRUD (Développeur A), l'implémentation de la logique métier algorithmique (Développeur B) et l'intégration de services tiers asynchrones complexes (Développeur C).
3.  **Clarté de la soutenance orale :** Cette organisation modulaire fournit une structure claire lors de la présentation du code face au jury. Chaque développeur peut présenter et défendre son périmètre technique de manière autonome.
