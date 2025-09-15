<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Toggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;

class CategoryCreateScreen extends Screen
{
    public $category;

    public function query(): array
    {
        $this->category = new Category();
        return [
            'category' => $this->category
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create Category';
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
                ->method('save'),
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
                Input::make('category.name')
                    ->title('Category Name')
                    ->placeholder('Enter category name')
                    ->required(),
                Input::make('category.description')
                    ->title('Category Description')
                    ->placeholder('Description'),
                Relation::make('category.parent_id')
                    ->title('Parent Category')
                    ->fromModel(Category::class, 'name')
                    ->help('Select a Category Parent if needed.'),
                CheckBox::make('category.is_active')
                    ->title('Active')->sendTrueOrFalse()
                
            ]),
        ];
    }

    public function categoryCreate()
    {
        $data = request('category');
        $category = Category::create($data);

        Toast::info("Category '{$category->name}' created successfully.");

        return redirect()->route('platform.categories');
    }

    public function save(Request $request,Category $category){
        
        $category->fill($request->get('category'))->save();

        Alert::info('Category created successfully!');

        return redirect()->route('platform.categories');
    }
}
