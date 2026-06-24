<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'total_price',
    'status',
    'shipping_address',
    'payment_intent_id',
])]
class Order extends Model
{
    use HasFactory;

    /**
     * Obtenir les attributs à convertir (casting).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Relation : La commande appartient à un utilisateur (relation belongsTo).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Produits inclus dans cette commande (relation Many-to-Many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->using(OrderProduct::class)
                    ->withPivot('id', 'quantity', 'price')
                    ->withTimestamps();
    }
}
