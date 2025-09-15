<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['provider', 'type', 'last_four', 'is_deafult'];

    public function orders(){
        return $this->belongsToMany(Order::class);
    }
}
