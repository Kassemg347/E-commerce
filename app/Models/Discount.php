<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable =['name', 'description', 'type', 'value', 'starts_at', 'ends_at', 'is_active'];

    public function category(){
        return $this->morphedByMany(Category::class, 'discountable');
    }

    public function brands(){
        return $this->morphedByMany(Brand::class,'discountable');
    }

    public function productVariants(){
        return $this->morphedByMany(ProductVariant::class,'discountable');
    }
}
