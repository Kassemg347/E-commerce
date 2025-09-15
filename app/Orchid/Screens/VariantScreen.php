<?php

namespace App\Orchid\Screens;

use App\Models\ProductVariant;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class VariantScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'product_variants' => ProductVariant::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Product Variants';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')
                ->route('platform.variants.create')
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
            Layout::table('product_variants', [
                TD::make('id', 'ID')
                    ->render(fn($variant) => $variant->id),
                TD::make('name', 'Name')
                    ->render(fn($variant) => $variant->name),
                TD::make('value', 'Value')
                    ->render(fn($variant) => $variant->value),
                TD::make('actions', 'Actions')
                    ->render(function($variant){
                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list([
                                Link::make('Edit')
                                    ->route('platform.variant.edit', $variant)
                                    ->icon('bs.pen'),
                                Button::make('Delete')
                                    ->icon('trash')
                                    ->confirm('Delete Product?')
                                    ->method('delete')
                                    ->parameters([
                                        'id' => $variant->id,
                                    ]),
                            ]);
                    })
            ])
        ];
    }
}
