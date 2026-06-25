<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest users are redirected to login when accessing admin pages', function () {
    $response = $this->get('/admin/products');

    $response->assertRedirect('/login');
});

test('non admin users cannot access admin pages', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/admin/products');

    $response->assertForbidden();
});

test('admin users can access admin pages', function () {
    $admin = User::factory()->admin()->create();

    $response = $this
        ->actingAs($admin)
        ->get('/admin/products');

    $response->assertOk();
});
