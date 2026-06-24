<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'order_id',
    'product_id',
    'quantity',
    'price',
])]
class OrderProduct extends Pivot
{
    /**
     * La table associée au modèle pivot.
     *
     * @var string
     */
    protected $table = 'order_product';

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
            'price' => 'decimal:2',
        ];
    }

    /**
     * Relation : La ligne de commande appartient à une commande (relation belongsTo).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relation : La ligne de commande fait référence à un produit (relation belongsTo).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
