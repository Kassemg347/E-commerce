<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['description', 'rating'];

    public function productVariant(){
       return $this->belongsTo(ProductVariant::class);
    }

    public function userReview(){
       return $this->belongsTo(User::class);
    }
}
