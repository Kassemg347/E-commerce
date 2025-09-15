<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function productVariants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function Cart(){
        return $this->belongsTo(Cart::class);
    }
}
