<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'price', 'cost', 'sku', 'is_active','stock'];
    protected $casts = ['is_active' => 'boolean'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function variantValue(){
        return $this->hasOne(VariantValue::class);
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}
