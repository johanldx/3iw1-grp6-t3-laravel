<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $products = $request->user()->cart()->with('category')->get();

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $products->sum(fn($p) => (float) $p->price * $p->pivot->quantity);

        return view('checkout.index', ['products' => $products, 'total' => $total]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $user = $request->user();
        $products = $user->cart()->get();

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $fullAddress = $request->input('shipping_address') . ', '
            . $request->input('postal_code') . ' '
            . $request->input('city');

        session(['pending_shipping_address' => $fullAddress]);

        $lineItems = $products->map(fn($p) => [
            'price_data' => [
                'currency'     => config('cashier.currency'),
                'unit_amount'  => (int) round($p->price * 100),
                'product_data' => ['name' => $p->name],
            ],
            'quantity' => $p->pivot->quantity,
        ])->values()->all();

        $checkoutSession = $user->checkout($lineItems, [
            'mode'        => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('checkout.index'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('home');
        }

        if (session('processed_stripe_session') === $sessionId) {
            $order = Order::find(session('last_order_id'));
            return view('checkout.success', ['order' => $order]);
        }

        $stripe = app(\Stripe\StripeClient::class);
        $stripeSession = $stripe->checkout->sessions->retrieve($sessionId);

        if ($stripeSession->payment_status !== 'paid') {
            return redirect()->route('checkout.index')->with('error', 'Paiement non confirmé. Veuillez réessayer.');
        }

        $user = $request->user();
        $products = $user->cart()->get();

        if ($products->isEmpty()) {
            return redirect()->route('home');
        }

        $total = $products->sum(fn($p) => (float) $p->price * $p->pivot->quantity);
        $address = session()->pull('pending_shipping_address', '');

        $order = Order::create([
            'user_id'          => $user->id,
            'total_price'      => $total,
            'status'           => 'paid',
            'shipping_address' => $address,
        ]);

        foreach ($products as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price'    => $product->price,
            ]);

            $product->decrement('stock', $product->pivot->quantity);
        }

        $user->cart()->detach();

        session(['processed_stripe_session' => $sessionId, 'last_order_id' => $order->id]);

        return view('checkout.success', ['order' => $order]);
    }
}
