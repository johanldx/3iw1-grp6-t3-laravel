<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can create and update a product with an image', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create([
        'name' => 'Soins du visage',
    ]);
    $otherCategory = Category::factory()->create([
        'name' => 'Parfums',
    ]);

    $createResponse = $this
        ->actingAs($admin)
        ->post('/admin/products', [
            'category_id' => $category->id,
            'name' => 'Serum Hydratant Aloe Vera',
            'barcode' => '1234567890128',
            'description' => 'Un serum leger pour hydrater la peau au quotidien.',
            'price' => '19.99',
            'stock' => 12,
            'image' => UploadedFile::fake()->image('serum.jpg'),
        ]);

    $createResponse
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin/products');

    $product = Product::first();

    expect($product)->not->toBeNull()
        ->and($product->slug)->toBe('serum-hydratant-aloe-vera');

    Storage::disk('public')->assertExists($product->image_path);

    $oldImagePath = $product->image_path;

    $updateResponse = $this
        ->actingAs($admin)
        ->put("/admin/products/{$product->slug}", [
            'category_id' => $otherCategory->id,
            'name' => 'Parfum Rose Douce',
            'barcode' => '4006381333931',
            'description' => 'Un parfum floral pour une utilisation quotidienne.',
            'price' => '29.90',
            'stock' => 7,
            'image' => UploadedFile::fake()->image('parfum.png'),
        ]);

    $updateResponse
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin/products');

    $product->refresh();

    expect($product->name)->toBe('Parfum Rose Douce')
        ->and($product->category_id)->toBe($otherCategory->id)
        ->and($product->barcode)->toBe('4006381333931');

    Storage::disk('public')->assertMissing($oldImagePath);
    Storage::disk('public')->assertExists($product->image_path);
});
