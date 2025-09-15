<?php

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'text',
            'parent_id'
        ]);
        $category = Category::create($request->all());
        return $category;
    }

    public function createOrUpdate(Request $request, Category $category)
    {

        if ($category == null) {
            //TODO create
            $this->create($request);

        } else {
            //TODO update
            $this->update($request,$category);
        }

        return $category;
    }
    public function update(Request $request, Category $category)
    {
        $category->fill($request->get('category'))->update();
        return $category;
    }
}