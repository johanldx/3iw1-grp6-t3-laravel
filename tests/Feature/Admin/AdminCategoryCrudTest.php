<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create and update a category', function () {
    $admin = User::factory()->admin()->create();

    $createResponse = $this
        ->actingAs($admin)
        ->post('/admin/categories', [
            'name' => 'Soins solaires',
        ]);

    $createResponse
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin/categories');

    $category = Category::first();

    expect($category)->not->toBeNull()
        ->and($category->slug)->toBe('soins-solaires');

    $updateResponse = $this
        ->actingAs($admin)
        ->put("/admin/categories/{$category->id}", [
            'name' => 'Hygiene',
        ]);

    $updateResponse
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin/categories');

    $category->refresh();

    expect($category->name)->toBe('Hygiene');
});

test('admin cannot delete a category that still has products', function () {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();
    Product::factory()->create([
        'category_id' => $category->id,
    ]);

    $response = $this
        ->actingAs($admin)
        ->delete("/admin/categories/{$category->id}");

    $response->assertRedirect('/admin/categories');
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
    ]);
});
