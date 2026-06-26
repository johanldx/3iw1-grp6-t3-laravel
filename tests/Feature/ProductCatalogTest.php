<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public home page is displayed and separated from catalogue', function () {
    $category = Category::factory()->create([
        'name' => 'Soins du visage',
    ]);

    Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Serum Hydratant Aloe Vera',
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSeeText('Boutique beaute & bien-etre');
    $response->assertSeeText('Nouveautes');
});

test('public catalogue page is displayed', function () {
    $category = Category::factory()->create([
        'name' => 'Soins du visage',
    ]);

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Serum Hydratant Aloe Vera',
    ]);

    $response = $this->get('/products');

    $response->assertOk();
    $response->assertSee('Tous les produits');
    $response->assertSee($product->name);
});

test('catalogue can be filtered by category slug', function () {
    $faceCategory = Category::factory()->create([
        'name' => 'Soins du visage',
    ]);
    $perfumeCategory = Category::factory()->create([
        'name' => 'Parfums',
    ]);

    $faceProduct = Product::factory()->create([
        'category_id' => $faceCategory->id,
        'name' => 'Serum Eclat Rose',
    ]);
    $perfumeProduct = Product::factory()->create([
        'category_id' => $perfumeCategory->id,
        'name' => 'Parfum Douceur Jasmin',
    ]);

    $response = $this->get('/products?category='.$faceCategory->slug);

    $response->assertOk();
    $response->assertSee($faceProduct->name);
    $response->assertDontSee($perfumeProduct->name);
});

test('public product page displays details and barcode', function () {
    $category = Category::factory()->create([
        'name' => 'Parfums',
    ]);
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Parfum Rose Douce',
        'barcode' => '4006381333931',
    ]);

    $response = $this->get('/products/'.$product->slug);

    $response->assertOk();
    $response->assertSee($product->name);
    $response->assertSee($product->barcode);
    $response->assertSee('svg', false);
});
