<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Products')
                ->title('Management')
                ->route('platform.products'),

            Menu::make('Categories')
                ->icon('bs.card-list')
                ->title('Navigation')
                ->route('platform.categories'),

            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),


            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            Menu::make('Brands')
                ->title('Management')
                ->route('platform.brands'),
            Menu::make('Variants')
                ->title('Product Management')
                ->route('platform.variants'),
            
            Menu::make('Combinations')
                ->title('Variants')
                ->route('platform.combinations'),
            Menu::make('Inventory')
                ->title('Inventory Management')
                ->route('platform.inventory'),
            Menu::make('Orders')
                ->route('platform.orders'),
            Menu::make('Carriers')
                ->route('platform.carriers'),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
