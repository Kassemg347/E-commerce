<?php

namespace App\Orchid\Screens;

use App\Models\Carrier;
use App\Services\CarrierService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class CarrierCreateEditScreen extends Screen
{
    public $carrier;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $this->carrier = new Carrier();
        return [
            'carriers' => $this->carrier
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create Carrier';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Add')
                ->icon('plus')
                ->method('create')
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
                Input::make('name')
                    ->title('Carrier Name'),
                Input::make('fee')
                    ->title('Fee')
                    ->type('number')
            ])
        ];
    }
    public function create(Request $request, CarrierService $carrierService){
        $carrierService->create($request);
        return redirect()->route('platform.carriers');
    }
}
