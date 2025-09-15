<?php

namespace App\Services;
use App\Models\Carrier;
use Illuminate\Http\Request;

class CarrierService
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|max:199.99|min:0',
        ]);
        $carrier = Carrier::create($request->all());
        return $carrier;
    }
}