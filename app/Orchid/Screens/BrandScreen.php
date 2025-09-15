<?php

namespace App\Orchid\Screens;

use App\Models\Brand;
use App\Services\BrandService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class BrandScreen extends Screen
{

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'brands' => Brand::withCount(['products', 'categories'])->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Brands';
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add New')
                ->route('platform.brands.create')
                ->icon('plus')
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

            Layout::table('brands', [
                TD::make('id', 'ID')
                    ->render(fn($brand) => $brand->id),
                TD::make('name', 'Name')
                    ->render(fn($brand) => $brand->name)
                    ->sort()
                    ->width('200px'),
                TD::make('description', 'Description')
                    ->render(fn($brand) => $brand->description),
                TD::make('is_active', 'Active')
                    ->render(fn($brand) => $brand->is_active ? 'True' : 'False'),
                TD::make('products_count', 'Products')
                    ->render(fn($brand) => $brand->products_count ?? 0)
                    ->sort()
                    ->width('150px'),
                    TD::make('categories_count', 'Categories')
                    ->render(fn($brand) => $brand->categories_count ?? 0)
                    ->sort()
                    ->width('150px'),
                TD::make('actions', 'Actions')
                    ->render(function ($brand) {
                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list([
                                Link::make('Edit')
                                    ->route('platform.brand.edit', $brand)
                                    ->icon('bs.pen'),
                                Button::make('Delete')
                                    ->icon('trash')
                                    ->confirm('Delete Brand?')
                                    ->method('delete')
                                    ->parameters([
                                        'id' => $brand->id,
                                    ]),
                            ]);
                    })
                    ->width('100px')
                    ->alignRight(),
            ])
        ];
    }
    public function delete($id, BrandService $brandService)
    {
        $brandService->delete($id);
    }
}