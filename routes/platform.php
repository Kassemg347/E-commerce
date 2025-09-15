<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Orchid\Screens\BrandCreateEditScreen;
use App\Orchid\Screens\BrandScreen;
use App\Orchid\Screens\CarrierCreateEditScreen;
use App\Orchid\Screens\CarrierScreen;
use App\Orchid\Screens\CategoryCreateScreen;
use App\Orchid\Screens\CategoryEditScreen;
use App\Orchid\Screens\CategoryScreen;
use App\Orchid\Screens\CombinationCreateScreen;
use App\Orchid\Screens\CombinationScreen;
use App\Orchid\Screens\InventoryCreateEditScreen;
use App\Orchid\Screens\InventoryScreen;
use App\Orchid\Screens\OrderCreateScreen;
use App\Orchid\Screens\OrderScreen;
use App\Orchid\Screens\ProductCreateEditScreen;
use App\Orchid\Screens\ProductScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\VariantCreateEditScreen;
use App\Orchid\Screens\VariantScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->push('Dashboard')
    );

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn(Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn(Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route(name: 'platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

Route::screen('categories', CategoryScreen::class)
    ->name('platform.categories')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Categories', route('platform.categories')));

Route::screen('categories/create', CategoryCreateScreen::class)->name('platform.category.create');

Route::screen('categories/{category}/edit', CategoryEditScreen::class)
    ->name('platform.category.edit');

Route::screen('products', ProductScreen::class)
    ->name('platform.products')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Products', route('platform.products')));

Route::screen('product/create', ProductCreateEditScreen::class)
    ->name('platform.products.create')
    ->defaults('mode', 'create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.products')
        ->push('Create Product', route('platform.products.create')));

Route::screen('product/{product}/edit', ProductCreateEditScreen::class)
    ->name('platform.product.edit')
    ->defaults('mode', 'edit')
    ->breadcrumbs(fn(Trail $trail, Product $product) => $trail
        ->parent('platform.products')
        ->push('Edit Product', route('platform.product.edit', ['product' => $product->id])));

Route::screen('brands', BrandScreen::class)
    ->name('platform.brands')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Brands', route('platform.brands')));

Route::screen('brands/create', BrandCreateEditScreen::class)
    ->name('platform.brands.create')
    ->defaults('mode', 'create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.brands')
        ->push('Create Brand', route('platform.brands.create')));

Route::screen('brands/{brand}/edit', BrandCreateEditScreen::class)
    ->name('platform.brand.edit')
    ->defaults('mode', 'edit')
    ->breadcrumbs(fn(Trail $trail, Brand $brand) => $trail
        ->parent('platform.brands')
        ->push('Edit Brand', route('platform.brand.edit', ['brand' => $brand->id])));

Route::screen('variants', VariantScreen::class)
    ->name('platform.variants')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Product Variants', route('platform.variants')));

Route::screen('variants/create', VariantCreateEditScreen::class)
    ->name('platform.variants.create')
    ->defaults('mode', 'create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.variants')
        ->push('Create Variant', route('platform.variants.create')));

Route::screen('variants/{variant}/edit', VariantCreateEditScreen::class)
    ->name('platform.variant.edit')
    ->defaults('mode', 'edit')
    ->breadcrumbs(fn(Trail $trail, ProductVariant $variant) => $trail
        ->parent('platform.variants')
        ->push('Edit Variant', route('platform.variant.edit', ['variant' => $variant->id])));

Route::screen('combinations', CombinationScreen::class)
    ->name('platform.combinations')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Variants Combinations', route('platform.combinations')));
Route::screen('combinations/create', CombinationCreateScreen::class)
    ->name('platform.combinations.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.combinations')
        ->push('Create Combination', route('platform.combinations.create')));

Route::screen('inventory', InventoryScreen::class)
    ->name('platform.inventory')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Inventory', route('platform.inventory')));
Route::screen('inventory/create', InventoryCreateEditScreen::class)
    ->name('platform.inventory.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.inventory')
        ->push('Create Product Inventory', route('platform.combinations.create')));

Route::screen('orders', OrderScreen::class)
    ->name('platform.orders')
    ->breadcrumbs(fn(Trail $trail) => $trail
    ->parent('platform.main')
    ->push('Orders', route('platform.orders')));
Route::screen('orders/create', OrderCreateScreen::class)
    ->name('platform.orders.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
    ->parent('platform.orders')
    ->push('Create Order', route('platform.orders.create')));

Route::screen('carriers', CarrierScreen::class)
    ->name('platform.carriers')
    ->breadcrumbs(fn(Trail $trail) => $trail
    ->parent('platform.main')
    ->push('Carriers', route('platform.carriers')));
Route::screen('carriers/create', CarrierCreateEditScreen::class)
    ->name('platform.carriers.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
    ->parent('platform.carriers')
    ->push('Create Carrier', route('platform.carriers.create')));
Route::screen('orders/{order}/edit', OrderCreateScreen::class)
    ->name('platform.order.edit')
    ->defaults('mode', 'edit')
    ->breadcrumbs(fn(Trail $trail, Order $order) => $trail
        ->parent('platform.orders')
        ->push('Edit Order', route('platform.order.edit', ['order' => $order->id])));
// Route::screen('idea', Idea::class, 'platform.screens.idea');
