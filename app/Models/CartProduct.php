<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'user_id',
    'product_id',
    'quantity',
])]
class CartProduct extends Pivot
{
    /**
     * La table associée au modèle pivot.
     *
     * @var string
     */
    protected $table = 'cart_product';

    /**
     * Indique si les IDs sont auto-incrémentés (Clé primaire présente sur la table pivot).
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Obtenir les attributs à convertir (casting).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    /**
     * Relation : La ligne du panier appartient à un utilisateur (relation belongsTo).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : La ligne du panier fait référence à un produit (relation belongsTo).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
