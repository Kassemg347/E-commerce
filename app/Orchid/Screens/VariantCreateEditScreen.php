<?php

namespace App\Orchid\Screens;

use App\Models\ProductVariant;
use App\Services\VariantService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class VariantCreateEditScreen extends Screen
{
    public $mode;
    public $productVariant;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ProductVariant $productVariant): iterable
    {
        if ($productVariant?->exists) {
            return [
                $this->productVariant = $productVariant,
                $this->mode = 'edit'
            ];
        } else {
            $this->productVariant = new ProductVariant();
            $this->mode = 'create';
        }
        return [
            'product_variant' => $this->productVariant
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return match ($this->mode) {
            'create' => 'Create Variant',
            'edit' => 'Edit Screen',
        };
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        if ($this->mode === 'create') {
            return [
                Button::make('Create')
                    ->icon('plus')
                    ->method('create')
            ];
        }
        return [
            Button::make('Save')
                ->icon('bs.check-lg')
                ->method('save')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        if ($this->mode === 'create') {
            return [
                Layout::rows([
                    Input::make('name')
                        ->title('Enter Variant Name.')
                        ->required(),
                    Input::make('value')
                        ->title('Enter variant value.')
                        ->required()
                ])
            ];
        }
        return [
            Input::make('name')
                ->title('Enter Variant Name.')
                ->required(),
            Input::make('value')
                ->title('Enter variant value.')
                ->required()
        ];
    }

    public function create(Request $request, VariantService $variantService)
    {
        $variantService->create($request);
        return redirect()->route('platform.variants');
    }
    public function save(Request $request, VariantService $variantService, ProductVariant $productVariant)
    {
        $variantService->update($request, $productVariant);
        return redirect()->route('platform.variants');
    }
}
