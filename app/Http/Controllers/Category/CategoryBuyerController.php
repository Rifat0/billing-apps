<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $buyer = $category->products()->whereHas('transactions')
        ->with('transactions.buyer')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->pluck('buyer')
        ->unique('id')
        ->values();
        return $this->showAll($buyer);
    }
}
