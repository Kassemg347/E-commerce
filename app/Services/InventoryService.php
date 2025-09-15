<?php

namespace App\Services;
use App\Models\Inventory;
use App\Models\ProductVariantCombinations;
use Illuminate\Http\Request;

class InventoryService
{
    public function create(Request $request)
    {
        $data = $request->input('inventory_data', []);

        foreach ($data as $row) {
            $validated = validator($row, [
                'product_variant_combination_id' => 'required|exists:product_variant_combinations,id',
                'total_quantity' => 'required|integer',
                'cost' => 'required|numeric',
            ])->validate();
            $validated['remaining_quantity'] = $validated['total_quantity'];

            Inventory::create($validated);
            ProductVariantCombinations::where('id', $validated['product_variant_combination_id'])->update(['cost' => $validated['cost']]);
        }
    }

    public function update(Request $request, Inventory $inventory){
        $inventory->fill($request->all())->update();
        return $inventory;
    }
    public function delete($id){
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
    }

    public function getProductsFromPivots(array $pivotIds)
    {
        return ProductVariantCombinations::with('product', 'combination')
            ->whereIn('id', $pivotIds)
            ->get()
            ->mapWithKeys(fn($pivot) => [
                $pivot->id => ($pivot->product?->name ?? 'Unknown') 
                            . ' - ' 
                            . ($pivot->combination?->name ?? 'Unknown')
            ])
            ->toArray();
    }
}