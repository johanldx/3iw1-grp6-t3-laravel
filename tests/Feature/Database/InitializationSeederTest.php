<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates the expected initial dataset with generated slugs', function () {
    $this->seed();

    expect(User::count())->toBe(6)
        ->and(User::where('email', 'admin@example.com')->where('is_admin', true)->exists())->toBeTrue()
        ->and(Category::count())->toBe(5)
        ->and(Product::count())->toBe(30)
        ->and(Category::whereNull('slug')->count())->toBe(0)
        ->and(Product::whereNull('slug')->count())->toBe(0)
        ->and(Product::whereNull('barcode')->count())->toBe(0);
});
