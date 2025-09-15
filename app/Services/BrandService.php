<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandService
{
    public function createBrand(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'brand.name' => 'required|string|max:255|unique:brands,name',
            'brand.description' => 'nullable|string',
            'brand.is_active' => 'boolean'
        ]);

        $brand = Brand::create($request->input('brand'));
        return $brand;
    }

    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(), [
            'brand.name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'brand.description' => 'nullable|string',
            'brand.is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $brand->update($request->input('brand'));
        return $brand;
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        // Check if brand has products
        if ($brand->products()->count() > 0) {
            throw new \Exception('Cannot delete brand with associated products.');
        }

        $brand->delete();
    }
}