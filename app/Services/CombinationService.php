<?php

namespace App\Services;

use App\Models\Combination;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;
class CombinationService
{
    public function create(Request $request)
    {
        $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*' => 'integer|exists:product_variants,id'
        ]);
        $variantNames = ProductVariant::whereIn('id', $request->input('variants'))
            ->pluck('name')
            ->toArray();
        $combination = Combination::create([
            'name' => implode(', ', $variantNames),
        ]);
        $combination->variants()->sync($request->input('variants'));
        Toast::info('Combination Created!');
        return $combination;
    }

    public function delete($id){
        $combination = Combination::findOrFail($id);
        $combination->delete();
    }
}