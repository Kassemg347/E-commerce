<?php

namespace App\Orchid\Screens;

use App\Models\Carrier;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CarrierScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'carriers' => Carrier::paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Carriers';
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
                ->route('platform.carriers.create')
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
            Layout::table('carriers',[
                TD::make('id', 'ID')
                    ->render(fn($carriers) => $carriers->id),
                TD::make('name', 'Name')
                    ->render(fn($carriers) => $carriers->name),
                TD::make('fee', 'Fee')
                    ->render(fn($carriers) => $carriers->fee),
            ])
        ];
    }
}
