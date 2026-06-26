<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Remplir la base de donnees de l'application.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'Administrateur',
                'email' => 'admin@example.com',
            ]);

        User::factory(5)->create();

        $categories = Category::factory()
            ->count(5)
            ->sequence(
                ['name' => 'Soins du visage'],
                ['name' => 'Soins du corps'],
                ['name' => 'Cheveux'],
                ['name' => 'Maquillage'],
                ['name' => 'Parfums'],
            )
            ->create();

        Product::factory(30)
            ->state(fn () => [
                'category_id' => $categories->random()->id,
            ])
            ->create();
    }
}
