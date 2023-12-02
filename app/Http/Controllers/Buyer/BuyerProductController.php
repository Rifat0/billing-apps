<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()->with('product')->get()->pluck('product');
        return $this->showAll($products);
    }
}
