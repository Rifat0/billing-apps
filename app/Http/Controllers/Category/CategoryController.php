<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          =>  'required',
            'description'   =>  'required'
        ]);

        $new_category = Category::create($request->all());
        return $this->showOne($new_category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'          =>  'required',
            'description'   =>  'required'
        ]);

        $category->fill($request->only([
            'name',
            'description'
        ]));

        if($category->isClean){
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $category->save();
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
