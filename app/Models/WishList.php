<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    public function productVariants(){
       return $this->hasMany(ProductVariant::class);
    }

    public function userWishlist(){
       return $this->belongsTo(User::class);
    }
}
