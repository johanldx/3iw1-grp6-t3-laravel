# 🤝 Note de passation pour le Développeur C (Paiement & Facturation)

Salut ! Voici un résumé simple de ce que j'ai fait pour la partie panier et commande (Développeur B), pour t'aider à brancher facilement la partie Stripe et la facturation (Développeur C).

---

## 🏗️ 1. Ce qui est déjà en place

### 🛒 Le Panier
*   **En base de données :** Le panier est stocké dans la table pivot `cart_product` (Many-to-Many entre `User` et `Product`).
*   **Mon contrôleur `CartController` :** Gère l'affichage, l'ajout (avec incrémentation de quantité), la suppression, et la mise à jour (avec sécurité sur le stock disponible).
*   **La vue :** C'est `resources/views/cart/index.blade.php`, elle est propre et en Tailwind.

### 💳 Le Tunnel de Commande (Checkout)
*   **Le contrôleur `CheckoutController` :**
    - `index()` : Affiche le récap avant paiement si le panier n'est pas vide.
    - `store()` : Valide l'adresse, crée la commande en base au statut `pending` (en attente), enregistre les articles dans `order_product` en figeant les prix unitaires, et vide le panier.
*   **Validation (`StoreOrderRequest`) :** Valide le nom, email, adresse, CP et ville.
*   **La vue (`resources/views/checkout/index.blade.php`) :**
    - Affiche le récap de la commande.
    - **Autocomplétion d'adresse :** J'ai mis un script JavaScript en bas de page qui appelle l'API officielle de l'État (data.gouv.fr). Dès qu'on commence à taper, ça propose des adresses réelles et pré-remplit la Ville et le Code Postal quand on clique dessus.
    - **Bloc paiement :** Il y a un cadre vide prévu pour tes inputs Stripe Elements.

### 📦 Admin des Commandes
*   J'ai créé l'onglet **"Commandes"** dans le menu admin.
*   **Index (`admin/orders`) :** Pour voir toutes les commandes passées.
*   **Détail (`admin/orders/{order}`) :** Pour voir les infos d'une commande (le client, l'adresse, les produits achetés avec leur prix historique et le code-barres).

### 🔗 Route Model Binding (Slugs)
*   J'ai configuré le modèle `Product` pour utiliser le **`slug`** à la place de l'**`id`** dans les URLs (ex: `/products/nom-du-produit`). Pas de changement pour toi, c'est géré automatiquement par Laravel.

---

## 🛠️ 2. Les fichiers importants

*   **Modèles :** `Product.php` et `Order.php`
*   **Contrôleurs :** `CheckoutController.php` (mon code de validation et de sauvegarde de commande) et `AdminOrderController.php`
*   **Request :** `StoreOrderRequest.php`
*   **Vues :** `checkout/index.blade.php`, `admin/orders/index.blade.php`, `admin/orders/show.blade.php`
*   **Tests :** `CheckoutTest.php` et `AdminOrderTest.php`

---

## 🚀 3. Ce que tu dois faire pour la suite (Partie Stripe & PDF)

> 💡 **Info importante :** J'ai déjà installé le SDK officiel **`stripe/stripe-php`** via Composer, tu n'as pas besoin de le faire. On évite d'utiliser Laravel Cashier qui est trop lourd (il crée plein de tables d'abonnements inutiles), c'est plus simple et plus propre d'utiliser directement le SDK Stripe.

### A. Intégrer Stripe sur la page de checkout
Dans `resources/views/checkout/index.blade.php`, tu as ce bloc pour insérer Stripe Elements :
```html
<!-- Conteneur pour le paiement sécurisé -->
<div class="bg-white rounded-3xl border border-[#eaded5] p-6 md:p-8 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)]">
    <h2 class="text-xl font-bold text-[#2f2a26] pb-4 border-b border-[#eaded5]/60 mb-6">
        Moyen de paiement sécurisé
    </h2>
    <div class="rounded-2xl border border-[#eaded5] bg-[#fcf7f3] p-6 text-center text-sm text-[#72645b]">
        <!-- Mets tes inputs Stripe ici ! -->
    </div>
</div>
```
Il faudra intercepter la soumission du formulaire en JS pour valider la carte bancaire via Stripe, obtenir le token de paiement, et l'envoyer dans un champ caché lors de la soumission finale.

### B. Le Webhook Stripe & mise à jour post-paiement
Quand tu reçois le webhook Stripe `payment_intent.succeeded` :
1. Passe le statut de la commande de `pending` à `paid`.
2. Déduis les stocks des produits de la commande dans la table `products`.
   ```php
   foreach ($order->products as $product) {
       $product->decrement('stock', $product->pivot->quantity);
   }
   ```

### C. Facturation PDF (Barryvdh Dompdf)
Pour générer les factures, utilise bien les prix stockés dans la table pivot `order_product` (via `$product->pivot->price` et `$product->pivot->quantity`), car ce sont les prix exacts payés le jour de l'achat.
