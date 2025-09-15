<?php

namespace App\Orchid\Screens;

use App\Models\Combination;
use App\Services\CombinationService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use function Termwind\render;

class CombinationScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'combinations' => Combination::with('variants')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Combinations';
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
                ->route('platform.combinations.create'),
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
            Layout::table('combinations', [
                TD::make('id', 'ID')
                    ->render(fn($combination) => $combination->id),
                TD::make('name', 'Combination Name')
                    ->render(fn($combination) => $combination->variants->pluck('name')->join(', ')),
                TD::make('actions', 'Actions')
                    ->render(function ($product) {
                        return Button::make('Delete')
                            ->icon('trash')
                            ->confirm('Delete Combination?')
                            ->method('delete')
                            ->parameters([
                                'id' => $product->id,
                            ]);
                    })
            ])
        ];
    }

    public function delete($id, CombinationService $combinationService)
    {
        $combinationService->delete($id);
    }
}
