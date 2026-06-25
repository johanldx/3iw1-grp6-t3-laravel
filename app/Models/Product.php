<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'barcode',
    'description',
    'price',
    'stock',
    'image_path',
])]
class Product extends Model
{
    use HasFactory, HasSlug;

    /**
     * Génère automatiquement un slug unique à partir du nom.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Obtenir les attributs à convertir (casting).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * Relation : Le produit appartient à une catégorie (relation belongsTo).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation : Utilisateurs ayant ce produit dans leur panier (relation Many-to-Many).
     */
    public function cartUsers()
    {
        return $this->belongsToMany(User::class, 'cart_product')
            ->using(CartProduct::class)
            ->withPivot('id', 'quantity')
            ->withTimestamps();
    }

    /**
     * Relation : Commandes contenant ce produit (relation Many-to-Many).
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->using(OrderProduct::class)
            ->withPivot('id', 'quantity', 'price')
            ->withTimestamps();
    }
}
