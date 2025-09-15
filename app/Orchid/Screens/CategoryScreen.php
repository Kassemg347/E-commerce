<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' => Category::withCount(['products', 'brands'])->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Categories';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add New')->route('platform.category.create')->icon('plus')
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
            Layout::table('categories', [
                TD::make('id', 'ID'),
                TD::make('name', 'Name'),
                TD::make('parent_id', 'Parent Category')
                    ->render(fn($category) => $category->parent?->name ?? '-'),
                TD::make('brands', 'Brands')
                    ->render(fn($category)=> $category->brands_count),
                TD::make('products', 'Products')
                    ->render(fn($category)=>$category->products_count),
                TD::make('is_active', 'Active')
                    ->render(function($category){
                        if($category->is_active)
                            return "true";
                        return "false";
                    }),
                TD::make('actions', 'Actions')->render(function ($category) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Edit')
                                ->route('platform.category.edit', $category)
                                ->icon('bs.pen'),
                            Button::make('Delete')
                                ->icon('trash')
                                ->confirm('Delete Category?')
                                ->method('delete')
                                ->parameters([
                                    'id' => $category->id,
                                ]),
                        ]);
                }),
            ]),
        ];
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        Toast::info('Category deleted successfully!');
    }
}
