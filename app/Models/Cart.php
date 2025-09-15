<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function CartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function userCart(){
        return $this->belongsTo(User::class);
    }
}
