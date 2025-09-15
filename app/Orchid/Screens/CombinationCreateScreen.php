<?php

namespace App\Orchid\Screens;

use App\Models\ProductVariant;
use App\Services\CombinationService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class CombinationCreateScreen extends Screen
{
    public $combination;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'combinations' => $this->combination
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create Combination';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Save')
                ->icon('bs.check-lg')
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
                Relation::make('variants')
                    ->title('Related Variants')
                    ->fromModel(ProductVariant::class, 'name')
                    ->multiple(),
            ])
        ];
    }

    public function create(Request $request, CombinationService $combinationService)
    {
        $combinationService->create($request);

        return redirect()->route('platform.combinations');
    }
}
