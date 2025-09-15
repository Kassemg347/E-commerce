<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantCombinations extends Model
{
    protected $fillable = ['product_id', 'combination_id', 'price', 'cost', 'sku', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', );
    }

    public function combination()
    {
        return $this->belongsTo(Combination::class, 'combination_id', );
    }

    public function inventory()
    {
        $this->belongsTo(Inventory::class);
    }

    public function orderItems() {
    return $this->hasMany(OrderItem::class, 'product_variant_combination_id');
}

    public function getProductNamesAttribute()
    {
        $productName = $this->product?->name ?? 'No Product';
        $combinationName = $this->combination?->variants->pluck('value')->implode(', ') ?? 'No Variant';
        return "$productName | $combinationName";
    }


}
