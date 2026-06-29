<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

#[Fillable(['name', 'email', 'password', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * Obtenir les attributs à convertir (casting).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relation : Produits dans le panier de l'utilisateur (relation Many-to-Many).
     */
    public function cart()
    {
        return $this->belongsToMany(Product::class, 'cart_product')
                    ->using(CartProduct::class)
                    ->withPivot('id', 'quantity')
                    ->withTimestamps();
    }

    /**
     * Relation : Commandes passées par l'utilisateur (relation One-to-Many).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

