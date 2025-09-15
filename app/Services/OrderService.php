<?php

namespace App\Services;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class OrderService
{
    public function create(Request $request)
    {
        //dd($request->all());
        $shippingAddress = $this->createAddress($request);
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_amount' => 0,
            'discount_amount' => 0,
            'subtotal_amount' => 0,
            'shipping_address_id' => $shippingAddress->id,
            'carrier_id' => $request->input('carrier_id'),
        ]);
        $data = $request->input('order', []);

        foreach ($data as $row) {
            $validated = validator($row, [
                'product_variant_combination_id' => 'required|exists:product_variant_combinations,id',
                'quantity' => 'required|integer',
            ])->validate();

            $order->orderItems()->create($validated);
        }
    }

    public function createAddress(Request $request)
    {
        $addressData = $request->only([
            'name',
            'phone_number',
            'country',
            'city',
            'state',
            'postal_code',
            'address_line_1',
            'address_line_2'
        ]);

        return UserAddress::create(array_merge(
            $addressData,
            ['user_id' => auth()->id()]
        ));
    }
}