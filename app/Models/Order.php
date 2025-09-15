<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total_amount', 'discount_amount','subtotal_amount', 'shipping_address_id', 'carrier_id'];
    protected $casts = ['status' => OrderStatus::class];
    public function userOrder(){
        return $this->belongsTo(User::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(){
        return $this->hasOne(UserAddress::class, 'shipping_addresses');
    }

    public function paymentMethod(){
        return $this->hasOne(PaymentMethod::class);
    }

    public function carrier(){
       return $this->belongsTo(Carrier::class);
    }

    public function productVariantCombination(){
        return $this->belongsTo(ProductVariantCombinations::class, 'product_variant_combination_id');
    }
}
