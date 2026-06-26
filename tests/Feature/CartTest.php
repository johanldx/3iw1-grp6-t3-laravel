<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest is redirected to login when visiting cart page', function () {
    $response = $this->get('/cart');

    $response->assertRedirect('/login');
});

test('authenticated user can see cart and total amount', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Huile Douce Relaxante',
        'price' => 19.90,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 2]);

    $response = $this
        ->actingAs($user)
        ->get('/cart');

    $response->assertOk();
    $response->assertSee($product->name);
    $response->assertSee('39,80 EUR');
});

test('adding a product increments quantity in cart', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'stock' => 5,
    ]);

    $this
        ->actingAs($user)
        ->post(route('cart.add', $product))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('cart_product', [
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this
        ->actingAs($user)
        ->post(route('cart.add', $product))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('cart_product', [
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 2,
    ]);
});

test('cart quantity cannot exceed available stock', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'stock' => 2,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 1]);

    $response = $this
        ->actingAs($user)
        ->from('/cart')
        ->patch(route('cart.update', $product), [
            'quantity' => 3,
        ]);

    $response->assertRedirect('/cart');
    $response->assertSessionHasErrors('quantity');

    $this->assertDatabaseHas('cart_product', [
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);
});

test('user can remove a product from cart', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 1]);

    $this
        ->actingAs($user)
        ->delete(route('cart.remove', $product))
        ->assertRedirect(route('cart.index'));

    $this->assertDatabaseMissing('cart_product', [
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);
});
