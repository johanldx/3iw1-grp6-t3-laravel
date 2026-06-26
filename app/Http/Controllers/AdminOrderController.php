<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    /**
     * Affiche la liste des commandes.
     */
    public function index(): View
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Affiche les détails d'une commande spécifique.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'products']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }
}
