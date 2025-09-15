<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    protected $fillable = ['name', 'fee'];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
