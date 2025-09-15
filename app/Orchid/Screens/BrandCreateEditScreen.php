<?php

namespace App\Orchid\Screens;

use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BrandCreateEditScreen extends Screen
{
    public $brand;
    public $mode;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Brand $brand): iterable
    {
        if ($brand?->exists) {
            $this->brand = $brand;
            $this->mode = 'edit';
        } else {
            $this->brand = new Brand();
            $this->mode = 'create';
        }
        return [
            'brand' => $this->brand
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
            'create' => 'Create Brand',
            'edit' => 'Edit Brand'
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
                Button::make('Add')
                    ->icon('plus')
                    ->method('create')
            ];
        }
        return [
            Button::make('Save')
                ->icon('bs.check-lg')
                ->method('edit')
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
                Input::make('brand.name')
                    ->title('Brand Name')
                    ->required(),
                TextArea::make('brand.description')
                    ->title('Description')
                    ->rows(5)
                    ->placeholder('Brand Details'),
                Switcher::make('brand.is_active')
                    ->title('Active')
                    ->sendTrueOrFalse()
            ])
        ];
    }

    public function create(Request $request, BrandService $brandService)
    {
        $brandService->createBrand($request);
        Toast::success('Brand created Successfully!');

        return redirect()->route('platform.brands');
    }
    public function edit(Request $request, BrandService $brandService, Brand $brand)
    {
        $brandService->update($request, $brand);
        Toast::success('Brand updated successfully!');

        return redirect()->route('platform.brands');
    }
}
