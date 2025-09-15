<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
//TODO CHange math
class Category extends Model
{
    use HasFactory, AsSource;
    protected $fillable = ['name', 'description', 'parent_id', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function products(){
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function discounts(){
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function scopeExcludeSelf($query, $categoryId){
        if($categoryId){
            return $query->where('id', '!=', $categoryId);
        }
        return $query;
    }
}
