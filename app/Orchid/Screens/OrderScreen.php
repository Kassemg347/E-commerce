<?php

namespace App\Orchid\Screens;

use App\Models\Order;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class OrderScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'orders' => Order::with(['carrier'])->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Orders';
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
                ->route('platform.orders.create')
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
            Layout::table('orders', [
                TD::make('id', 'ID')
                    ->render(fn($order) => $order->id),
                // TD::make('name', 'Name')
                //     ->render(fn($order) => $order->shippingAddresses->name),
                TD::make('total_amount', 'Total')
                    ->render(fn($order) => '$' . number_format($order->total_amount, 2)),
                TD::make('discount_amount', 'Discount Amount')
                    ->render(fn($order) => $order->discount_amount)
                ,
                TD::make('subtotal_amount', 'Subtotal Amount')
                    ->render(fn($order) => $order->subtotal_amount),
                // TD::make('status', 'Status')
                //     ->render(fn($order) => $order->),
                TD::make('carrier_id', 'Carrier')
                    ->render(fn($order) => $order->carrier->name),
                    TD::make('actions', 'Actions')
                    ->render(function ($order) {
                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list([
                                Link::make('Edit')
                                    ->route('platform.order.edit', $order)
                                    ->icon('bs.pen'),
                                Button::make('Cancel Order')
                                    ->icon('trash')
                                    ->confirm('Cancel Order?')
                                    ->method('delete')
                                    ->parameters([
                                        'id' => $order->id,
                                    ]),
                            ]);
                    })
            ])
        ];
    }
}
