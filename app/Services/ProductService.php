<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariantCombinations;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class ProductService
{
    public function create(Request $request)
    {
        $validated = $this->validateProductData($request);
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);
        $product->categories()->sync($validated['categories']);
        $this->syncCombinations($product, $validated['combination_data']);

        Toast::info('Product created successfully!');
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProductData($request);
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);
        $product->categories()->sync($validated['categories']);
        $this->syncCombinations($product, $validated['combination_data']);

        Toast::info('Product Updated!');
        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    protected function validateProductData(Request $request){
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'is_active' => 'boolean',

            'combination_data' => 'required|array|min:1',
            'combination_data.*.combination_id' => 'required|exists:combinations,id',
            'combination_data.*.price' => 'required|numeric|min:0',
            'combination_data.*.cost' => 'required|numeric|min:0',
            'combination_data.*.sku' => 'nullable|string|max:100',
            'combination_data.*.is_active' => 'boolean',
        ]);
    }

    protected function syncCombinations(Product $product, array $combinationData){
        foreach ($combinationData as $comboData) {
            $combination = ProductVariantCombinations::create([
                'product_id' => $product->id,
                'combination_id' => $comboData['combination_id'],
                'price' => $comboData['price'],
                'cost' => $comboData['cost'],
                'sku' => $comboData['sku'] ?? '',
                'is_active' => $comboData['is_active'] ?? true,
            ]);
        }
        return $combination;
    }
}