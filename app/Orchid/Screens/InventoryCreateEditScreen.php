<?php

namespace App\Orchid\Screens;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductVariantCombinations;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class InventoryCreateEditScreen extends Screen
{
    public $inventory;
    public $mode;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Inventory $inventory): iterable
    {
        if ($inventory?->exists) {
            $this->inventory = $inventory;
            $mode = 'Edit';
        } else {
            $inventory = new Inventory();
            $mode = 'Create';
        }
        return [
            'inventories' => $this->inventory
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'InventoryCreateEditScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create')
                ->icon('plus')
                ->method('create'),
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
            Layout::rows([
                Matrix::make('inventory_data')
                    ->title('Product Inventory')
                    ->columns([
                        'Product' => 'product_variant_combination_id',
                        'Quantity' => 'total_quantity',
                        'Cost' => 'cost',
                    ])
                    ->fields([
                        'product_variant_combination_id' => Relation::make('product_variant_combinations')
                            ->fromModel(ProductVariantCombinations::class, 'id')
                            ->displayAppend('product_names')
                            ->title('Products')
                            ->required(),
                        'total_quantity' => Input::make('total_quantity')
                            ->title('Quantity')
                            ->required(),
                        'cost' => Input::make('cost')
                            ->title('Cost')
                            ->required()
                        //TODO: add cost to inventory and remove from product 
                    ])
            ])

        ];
    }

    public function create(Request $request, InventoryService $inventoryService)
    {
        //dd($request->all());
        $inventoryService->create($request);
        return redirect()->route('platform.inventory');
    }
}
