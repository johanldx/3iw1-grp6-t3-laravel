<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Affiche le panier de l'utilisateur connecte.
     */
    public function index(Request $request): View
    {
        $products = $request->user()->cart()
            ->with('category')
            ->orderByDesc('cart_product.created_at')
            ->get();

        $total = $products->sum(function (Product $product) {
            return (float) $product->price * $product->pivot->quantity;
        });

        return view('cart.index', [
            'products' => $products,
            'total' => $total,
        ]);
    }

    /**
     * Ajoute un produit au panier ou incremente sa quantite.
     */
    public function add(Request $request, Product $product): RedirectResponse
    {
        $cartProduct = $request->user()->cart()
            ->where('products.id', $product->id)
            ->first();

        $currentQuantity = $cartProduct?->pivot->quantity ?? 0;
        $newQuantity = $currentQuantity + 1;

        if ($product->stock < $newQuantity) {
            return back()->with('error', 'La quantite demandee depasse le stock disponible.');
        }

        if ($cartProduct) {
            $request->user()->cart()->updateExistingPivot($product->id, [
                'quantity' => $newQuantity,
            ]);
        } else {
            $request->user()->cart()->attach($product->id, [
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Le produit a bien ete ajoute au panier.');
    }

    /**
     * Met a jour la quantite d'un produit dans le panier.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->user()->cart()
            ->where('products.id', $product->id)
            ->firstOrFail();

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ((int) $validated['quantity'] > $product->stock) {
            return back()
                ->withErrors([
                    'quantity' => 'La quantite demandee depasse le stock disponible.',
                ])
                ->withInput();
        }

        $request->user()->cart()->updateExistingPivot($product->id, [
            'quantity' => (int) $validated['quantity'],
        ]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'La quantite a bien ete mise a jour.');
    }

    /**
     * Supprime un produit du panier.
     */
    public function remove(Request $request, Product $product): RedirectResponse
    {
        $request->user()->cart()->detach($product->id);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Le produit a bien ete retire du panier.');
    }
}
