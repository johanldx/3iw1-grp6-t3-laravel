<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest is redirected to login when visiting checkout page', function () {
    $response = $this->get('/checkout');

    $response->assertRedirect('/login');
});

test('authenticated user with empty cart is redirected to cart page', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/checkout');

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('error', 'Votre panier est vide.');
});

test('authenticated user with items in cart can see checkout page', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Soin Hydratant',
        'price' => 15.00,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 1]);

    $response = $this
        ->actingAs($user)
        ->get('/checkout');

    $response->assertOk();
    $response->assertSee($product->name);
    $response->assertSee('15,00 EUR');
});

test('checkout validation fails with invalid delivery details', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 1]);

    $response = $this
        ->actingAs($user)
        ->post('/checkout', [
            'name' => '',
            'email' => 'invalid-email',
            'shipping_address' => 'Short',
            'postal_code' => '',
            'city' => '',
        ]);

    $response->assertSessionHasErrors(['name', 'email', 'shipping_address', 'postal_code', 'city']);
});

test('checkout redirects to stripe checkout session', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'price' => 20.00,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 2]);

    $mockCheckout = Mockery::mock(\Laravel\Cashier\Checkout::class);
    $mockCheckout->url = 'https://checkout.stripe.com/test-session-url';

    $mockUser = Mockery::mock($user)->makePartial();
    $mockUser->shouldReceive('checkout')
        ->once()
        ->andReturn($mockCheckout);

    $response = $this
        ->actingAs($mockUser)
        ->post('/checkout', [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'shipping_address' => '123 Rue de la République',
            'postal_code' => '69002',
            'city' => 'Lyon',
        ]);

    $response->assertRedirect('https://checkout.stripe.com/test-session-url');
    expect(session('pending_shipping_address'))->toBe('123 Rue de la République, 69002 Lyon');
});

test('checkout success creates order and decrements product stock', function () {
    $stripeMock = Mockery::mock(\Stripe\StripeClient::class);
    $sessionsMock = Mockery::mock();
    $stripeMock->checkout = (object) ['sessions' => $sessionsMock];

    $sessionsMock->shouldReceive('retrieve')
        ->with('test_session_id')
        ->once()
        ->andReturn((object) ['payment_status' => 'paid']);

    app()->instance(\Stripe\StripeClient::class, $stripeMock);

    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'price' => 20.00,
        'stock' => 10,
    ]);

    $user->cart()->attach($product->id, ['quantity' => 2]);

    session(['pending_shipping_address' => '123 Rue de la République, 69002 Lyon']);

    $response = $this
        ->actingAs($user)
        ->get('/checkout/success?session_id=test_session_id');

    $response->assertOk();

    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'total_price' => 40.00,
        'status' => 'paid',
        'shipping_address' => '123 Rue de la République, 69002 Lyon',
    ]);

    $this->assertDatabaseMissing('cart_product', [
        'user_id' => $user->id,
    ]);

    expect($product->fresh()->stock)->toBe(8);
});


