<?php

namespace App\Orchid\Screens;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Combination;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ProductCreateEditScreen extends Screen
{
    public $product;
    public $mode;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Product $product): iterable
    {
        if ($product?->exists) {
            $this->product = $product;
            $this->mode = 'edit';
        } else {
            $this->product = new Product();
            $this->mode = 'create';
        }

        return [
            'product' => $this->product
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
            'create' => 'Create Product',
            'edit' => 'Edit Product'
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
        } else {
            return [
                Button::make('Save')
                    ->icon('bs.check-lg')
                    ->method('edit')
            ];
        }
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'General Information' => [
                    Layout::rows([
                        Input::make('name')
                            ->title('Product Name')
                            ->placeholder('Enter a Product')
                            ->value($this->product->name ?? '')
                            ->required(),
                        TextArea::make('description')
                            ->title('Description')
                            ->rows(5)
                            ->placeholder('Description...')
                            ->value($this->product->description ?? '')
                            ->required(),
                        Switcher::make('is_active')
                            ->title('Active')
                            ->value($this->product->is_active)
                            ->sendTrueOrFalse(),
                    ])
                ],
                'Pricing & Variants' => [
                    Layout::rows([
                        Matrix::make('combination_data')
                            ->title('Variants')
                            ->columns([
                                'Variant' => 'combination_id',
                                'Price' => 'price',
                                'Cost' => 'cost',
                                'SKU' => 'sku',
                                'Active' => 'is_active',
                            ])
                            ->fields([
                                'combination_id' => Relation::make('combination_id')
                                    ->fromModel(Combination::class, 'id')
                                    ->displayAppend('combination_values')
                                    ->title('Variant')
                                    ->required(),
                                'price' => Input::make('price')
                                    ->type('number')
                                    ->title('Price')
                                    ->required(),
                                'cost' => Input::make('cost')
                                    ->type('number')
                                    ->title('Cost')
                                    ->required(),
                                'sku' => Input::make('sku')->title('SKU'),
                                'is_active' => Switcher::make('is_active')
                                    ->title('Active')
                                    ->sendTrueOrFalse(),
                            ])
                            ->value(
                                $this->product?->productCombinations
                                    ?->map(function($combo){
                                        return [
                                            'combination_id' => $combo->combination_id,
                                            'price'=> $combo->price,
                                            'cost' => $combo->cost,
                                            'sku' => $combo->sku,
                                            'is_active' => $combo->is_active,
                                        ];
                                    })->toArray()
                            )
                    ])
                ],
                'Brand/Category' => [
                    Layout::rows([
                        Relation::make('categories.')
                            ->title('Related Categories')
                            ->fromModel(Category::class, name: 'name')
                            ->multiple()
                            //->value($this->product->categories->pluck('name')->join(', ') ?: '—')
                            ->help('Select related category.'),
                        Relation::make('brand_id')
                            ->title('Related Brand')
                            ->fromModel(Brand::class, 'name')
                            //->value($this->product->brand->name)
                            ->help('Select related brand.')
                    ])
                    //TODO:check category and brand selected prev in edit
                ],
            ])
        ];

    }

    public function create(Request $request, ProductService $productService)
    {
        //dd($request->all());
        $productService->create($request);
        return redirect()->route('platform.products');
    }

    public function edit(Request $request, ProductService $productService, Product $product)
    {
        $productService->update($request, $product);
        return redirect()->route('platform.products');
    }
}
