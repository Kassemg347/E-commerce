<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'brand_id', 'is_active'];

    protected $casts = ['brand_id' => 'integer', 'category_id' => 'integer', 'is_active' => 'boolean'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variant(){
        return $this->hasOne(ProductVariant::class);
    }

    public function attributeSets(){
        return $this->belongsTo(AttributeSet::class);
    }
}
