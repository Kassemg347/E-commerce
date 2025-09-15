<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $fillable = ['product_variant_combination_id', 'total_quantity', 'cost', 'remaining_quantity'];

    public function productVariantCombinations(){
        return $this->belongsTo(ProductVariantCombinations::class, 'product_variant_combination_id');
    }
}
