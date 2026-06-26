<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot access admin orders index', function () {
    $response = $this->get('/admin/orders');

    $response->assertRedirect('/login');
});

test('standard user cannot access admin orders index', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $response = $this
        ->actingAs($user)
        ->get('/admin/orders');

    $response->assertStatus(403);
});

test('admin can access admin orders index', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $user = User::factory()->create();
    
    $order = Order::create([
        'user_id' => $user->id,
        'total_price' => 50.00,
        'status' => 'pending',
        'shipping_address' => '123 Rue Principale, 75001 Paris',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin/orders');

    $response->assertOk();
    $response->assertSee('#' . $order->id);
    $response->assertSee($user->name);
    $response->assertSee('50,00 EUR');
});

test('admin can view specific order details', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Soin Hydratant Hydrolat',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'total_price' => 30.00,
        'status' => 'paid',
        'shipping_address' => '456 Avenue des Roses, 69002 Lyon',
    ]);

    $order->products()->attach($product->id, [
        'quantity' => 1,
        'price' => 30.00,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin/orders/' . $order->id);

    $response->assertOk();
    $response->assertSee('Détails de la commande #' . $order->id);
    $response->assertSee($user->name);
    $response->assertSee($user->email);
    $response->assertSee($product->name);
    $response->assertSee('456 Avenue des Roses, 69002 Lyon');
});
