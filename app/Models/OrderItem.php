<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['product_variant_combination_id', 'quantity'];
    public function orders(){
        return $this->belongsTo(Order::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function productVariantCombination(){
        return $this->belongsTo(ProductVariantCombinations::class,'product_variant_combination_id');
    }
}
