<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug'])]
class Category extends Model
{
    use HasFactory;

    /**
     * Relation : Une catégorie possède plusieurs produits (relation One-to-Many).
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
