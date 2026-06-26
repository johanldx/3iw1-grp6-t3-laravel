<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Affiche le récapitulatif de la commande et le formulaire d'adresse.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $products = $request->user()->cart()->with('category')->get();

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $products->sum(function ($product) {
            return (float) $product->price * $product->pivot->quantity;
        });

        return view('checkout.index', [
            'products' => $products,
            'total' => $total,
        ]);
    }

    /**
     * Valide l'adresse et crée la commande en attente de paiement.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $user = $request->user();
        $products = $user->cart()->get();

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $products->sum(function ($product) {
            return (float) $product->price * $product->pivot->quantity;
        });

        $fullAddress = $request->input('shipping_address') . ', ' . $request->input('postal_code') . ' ' . $request->input('city');

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'status' => 'pending',
            'shipping_address' => $fullAddress,
        ]);

        foreach ($products as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
            ]);
        }

        $user->cart()->detach();

        return redirect()->route('home')->with('success', 'Votre commande a été passée avec succès !');
    }
}
