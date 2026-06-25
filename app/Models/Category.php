<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable(['name', 'slug'])]
class Category extends Model
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
     * Relation : Une catégorie possède plusieurs produits (relation One-to-Many).
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
