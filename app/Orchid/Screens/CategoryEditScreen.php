<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use CategoryService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    public $category;

    public function query(Category $category): iterable
    {
        $this->category = $category;
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
        return 'CategoryEditScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Update')
             ->icon('bs.check-lg')
             ->method('update'),

            Button::make('Back')
                ->icon('bs.chevron-left')
                ->method('back'),
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
                    ->title( 'Category Name')
                    ->placeholder('Enter category name.')
                    ->value($this->category->name)
                    ->required(),
                Input::make('category.description')
                    ->title('Category Description')
                    ->placeholder('Description'),
                Relation::make('category.parent_id')
                    ->title('Parent Category')
                    ->value($this->category->parent_id)
                    ->fromModel(Category::class, 'name')
                    ->applyScope('excludeSelf', [$this->category->id])
                    ->help('Select a Category Parent if needed.'),
                     CheckBox::make('category.is_active')
                    ->title('Active')->sendTrueOrFalse()
                
            ]),
        ];
    }

    public function update(Request $request, Category $category){
        
        $category->fill($request->get('category'))->update();

        Toast::info('Category updated');
        return redirect()->route('platform.categories');
    }

    public function back(){
        return redirect()->route('platform.categories');
    }
}
