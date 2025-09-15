<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use App\Services\ProductService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use function Termwind\render;

class ProductScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' => Product::with(['categories', 'brand', 'productCombinations.combination.variants'])->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Products';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('plus')
                ->route('platform.products.create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('products', [
                TD::make('id', 'ID')
                    ->render(fn($product) => $product->id),
                TD::make('name', 'Name')
                    ->render(fn($product) => $product->name),
                TD::make('categories', 'Categories')
                    ->render(fn($product) => $product->categories->pluck('name')->join(', ') ?: '—'),
                TD::make('brand', 'Brand')
                    ->render(fn($product) => $product->brand->name),
                TD::make('combinations', 'Variants')
                    ->render(function ($product) {
                        return $product->productCombinations->map(function ($comboPivot) {
                            return $comboPivot->combination->variants->pluck('name')->join(', ');
                        })->join('<br>');
                    }),
                TD::make('price', 'Price')
                    ->render(function ($product) {
                        return $product->productCombinations->pluck('price')->join('<br>');
                    }),
                TD::make('cost', 'Cost')
                    ->render(function ($product) {
                        return $product->productCombinations->pluck('cost')->join('<br>');
                    }),
                TD::make('sku', 'SKU')
                    ->render(function ($product) {
                        return $product->productCombinations->pluck('sku')->join('<br>');
                    }),
                TD::make('is_active', 'Variant Active')
                    ->render(function ($product) {
                       return $product->productCombinations->map(function($combo){
                        return $combo->is_active ? 'True' : 'False';
                       })->join('<br>');
                    }),
                TD::make('product.is_active', 'Active')
                    ->render(fn($product) => $product->is_active ? 'True' : 'False'),
                TD::make('actions', 'Actions')
                    ->render(function ($product) {
                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list([
                                Link::make('Edit')
                                    ->route('platform.product.edit', $product)
                                    ->icon('bs.pen'),
                                Button::make('Delete')
                                    ->icon('trash')
                                    ->confirm('Delete Product?')
                                    ->method('delete')
                                    ->parameters([
                                        'id' => $product->id,
                                    ]),
                            ]);
                    })
            ])
        ];
    }

    public function delete($id, ProductService $productService)
    {
        $productService->delete($id);
    }
}
