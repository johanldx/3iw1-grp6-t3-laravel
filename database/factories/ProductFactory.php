<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Liste simple de produits orientés beauté / bien-être.
     *
     * @var string[]
     */
    private array $productTypes = [
        'Serum',
        'Creme hydratante',
        'Masque',
        'Shampoing',
        'Apres-shampoing',
        'Huile de soin',
        'Baume',
        'Gel nettoyant',
        'Lotion',
        'Parfum',
        'Rouge a levres',
        'Fond de teint',
    ];

    /**
     * @var string[]
     */
    private array $benefits = [
        'hydratant',
        'nourrissant',
        'apaisant',
        'revitalisant',
        'protecteur',
        'eclat',
        'reparateur',
    ];

    /**
     * @var string[]
     */
    private array $ingredients = [
        'aloe vera',
        'karite',
        'huile d argan',
        'vitamine C',
        'collagene',
        'acide hyaluronique',
        'fleur de coton',
        'rose',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productType = fake()->randomElement($this->productTypes);
        $benefit = fake()->randomElement($this->benefits);
        $ingredient = fake()->randomElement($this->ingredients);

        return [
            'category_id' => Category::factory(),
            'name' => $this->buildProductName($productType, $benefit, $ingredient),
            'barcode' => $this->generateEan13Barcode(),
            'description' => $this->buildProductDescription($productType, $benefit, $ingredient),
            'price' => fake()->randomFloat(2, 5, 999.99),
            'stock' => fake()->numberBetween(0, 100),
            'image_path' => null,
        ];
    }

    /**
     * Construit un nom de produit simple et plausible.
     */
    private function buildProductName(string $productType, string $benefit, string $ingredient): string
    {
        return ucfirst($productType).' '.ucfirst($benefit).' '.$this->formatIngredient($ingredient);
    }

    /**
     * Construit une description courte dans le meme univers produit.
     */
    private function buildProductDescription(string $productType, string $benefit, string $ingredient): string
    {
        return sprintf(
            '%s concu pour un usage quotidien avec une action %s. Sa formule a base de %s aide a prendre soin de la peau ou des cheveux tout en apportant confort et douceur.',
            ucfirst($productType),
            $benefit,
            $ingredient
        );
    }

    /**
     * Formate l ingredient pour l integrer dans le nom du produit.
     */
    private function formatIngredient(string $ingredient): string
    {
        return ucwords($ingredient);
    }

    /**
     * Génère un code EAN-13 valide et unique.
     */
    private function generateEan13Barcode(): string
    {
        static $usedBarcodes = [];

        do {
            $base = fake()->numerify('############');
            $barcode = $base.$this->calculateEan13Checksum($base);
        } while (in_array($barcode, $usedBarcodes, true));

        $usedBarcodes[] = $barcode;

        return $barcode;
    }

    /**
     * Calcule le chiffre de contrôle EAN-13 à partir des 12 premiers chiffres.
     */
    private function calculateEan13Checksum(string $base): int
    {
        $sum = 0;

        foreach (str_split($base) as $index => $digit) {
            $multiplier = $index % 2 === 0 ? 1 : 3;
            $sum += ((int) $digit) * $multiplier;
        }

        return (10 - ($sum % 10)) % 10;
    }
}
