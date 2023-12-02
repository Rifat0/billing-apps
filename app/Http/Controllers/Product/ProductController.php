<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }
}
