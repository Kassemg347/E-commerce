<?php

namespace App\Services;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class VariantService{
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255'
        ]);
        $product_variant = ProductVariant::create($request->all());
    }

    public function update(Request $request, ProductVariant $productVariant){
        $productVariant->fill($request->get('product_variant'))->update();
        Toast::info('Variant Updated!');
        return $productVariant;
    }
}