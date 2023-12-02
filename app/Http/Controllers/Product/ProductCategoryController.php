<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    public function index(Product $product)
    {
        $category = $product->categories;
        return $this->showAll($category);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->attach($category->id);
        return $this->showAll($product->categories);

    }

    public function destroy(Product $product, Category $category)
    {
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('This specific category is not exist.', 404);
        }
        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
