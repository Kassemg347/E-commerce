<?php

namespace App\Orchid\Screens;

use App\Enums\OrderStatus;
use App\Models\Carrier;
use App\Models\Order;
use App\Models\ProductVariantCombinations;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class OrderCreateScreen extends Screen
{
    public $order;
    public $mode;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Order $order): iterable
    {
        if ($order?->exists) {
            $this->order = $order;
            $mode = 'edit';
        } else {
            $this->order = new Order;
            $mode = 'create';
        }
        return [
            'order' => $this->order
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->mode === 'create') ? 'Create Order' : 'Edit Order';
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
            Button::make('Update')
                ->icon('plus')
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
        if ($this->mode === 'create') {
            return [
                Layout::tabs([
                    'Address' => [
                        Layout::rows([
                            Input::make('name')
                                ->title('Name')
                                ->required(),
                            Input::make('phone_number')
                                ->title('Phone Number')
                                ->required(),
                            Input::make('country')
                                ->title('Country')
                                ->required(),
                            Input::make('city')
                                ->title('City')
                                ->required(),
                            Input::make('state')
                                ->title('State'),
                            Input::make('postal_code')
                                ->title('Postal Code'),
                            Input::make('address_line_1')
                                ->title('Address Line 1')
                                ->required(),
                            Input::make('address_line_2')
                                ->title('Address Line 2'),
                        ])
                    ],
                    'Add Products' => [
                        Layout::rows([
                            Matrix::make('order')
                                ->columns([
                                    'Product' => 'product_variant_combination_id',
                                    'Quantity' => 'quantity',
                                ])
                                ->fields(fields: [
                                    'product_variant_combination_id' => Relation::make('product_variant_combinations')
                                        ->fromModel(ProductVariantCombinations::class, 'id')
                                        ->displayAppend('product_names')
                                        ->required(),
                                    'quantity' => Input::make('quantity')
                                        ->type('number')
                                        ->min(1)
                                        ->step(1)
                                        ->value(1),
                                ])
                        ])
                    ],
                    'Carrier' => [
                        Layout::rows([
                            Relation::make('carrier_id')
                                ->title('Carrier')
                                ->fromModel(Carrier::class, 'name')
                        ])
                    ]
                ]),
            ];
        }
        return [
            Layout::rows([
                Select::make('status')
                    ->title('Order Status')
                    ->options(
                        collect(OrderStatus::cases())
                            ->mapWithKeys(fn($case) => [$case->value => ucfirst($case->value)])
                            ->toArray()
                    )
                    ->value($order->status->value ?? null)
            ])
        ];
    }

    public function create(Request $request, OrderService $orderService)
    {
        $orderService->create($request);
        return redirect()->route('platform.orders');
    }
}
