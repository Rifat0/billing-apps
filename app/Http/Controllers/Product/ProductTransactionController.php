<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $transaction = $product->transactions;
        return $this->showAll($transaction);
    }

    public function update(Request $request, Product $product)
    {
        $product->quantity = $request->quantity;
        $product->save();
        return $this->showOne($product);
    }
}
