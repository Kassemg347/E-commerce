<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //protected $fillable = ['name', 'phone_number', 'country', 'city', 'state', 'postal_code', 'address_line_1', 'address_line_2'];

    protected $table = 'shipping_addresses';
    protected $guarded =[];
    public function user(){
       return $this->belongsTo(User::class);
    }
    public function orders(){
        return $this->hasMany(Order::class, 'order_id');
    }
}
