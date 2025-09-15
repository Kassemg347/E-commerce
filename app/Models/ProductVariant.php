<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['name', 'value', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function combinations()
    {
        return $this->belongsToMany(Combination::class, 'combination_variants', 'combination_id', 'product_variant_id');
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
