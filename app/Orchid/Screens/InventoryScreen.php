<?php

namespace App\Orchid\Screens;

use App\Models\Inventory;
use App\Services\InventoryService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class InventoryScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'inventory' => Inventory::with(['productVariantCombinations.product', 'productVariantCombinations.combination'])->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Inventory';
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
                ->icon('plus')
                ->route('platform.inventory.create')
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
            Layout::table('inventory', [
                TD::make('id', 'ID')
                    ->render(fn($inventory) => $inventory->id),
                TD::make('name', 'Product Name')
                    ->render(fn($inventory) => $inventory->productVariantCombinations->product?->name),
                TD::make('cost', 'Cost')
                    ->render(fn($inventory) => $inventory->cost),
                TD::make('name', 'Variants')
                    ->render(fn($inventory) => $inventory->productVariantCombinations->combination?->variants->pluck('value')->implode(', ')),
                TD::make('total_quantity')
                    ->render(fn($inventory) => $inventory->total_quantity),
                TD::make('remaining_quantity')
                    ->render(fn($inventory) => $inventory->remaining_quantity),
                TD::make('reserved_quantity')
                    ->render(fn($inventory) => $inventory->reserved_quantity),
                TD::make('updated_at', 'Date')
                    ->render(fn($inventory) => $inventory->updated_at),
                TD::make('actions', 'Actions')
                    ->render(function ($inventory) {
                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list([
                                Link::make('Edit')
                                    ->route('platform.product.edit', $inventory)
                                    ->icon('bs.pen'),
                                Button::make('Delete')
                                    ->icon('trash')
                                    ->confirm('Delete Product?')
                                    ->method('delete')
                                    ->parameters([
                                        'id' => $inventory->id,
                                    ]),
                            ]);
                    })
            ])
        ];
    }

    public function delete($id, InventoryService $inventoryService)
    {
        $inventoryService->delete($id);
    }
}
