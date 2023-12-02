<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $buyer = $seller->products()->whereHas('transactions')->with('transactions.buyer')
                ->get()
                ->pluck('transactions')
                ->collapse()
                ->pluck('buyer')
                ->unique('id')
                ->values();
        return $this->showAll($buyer);
    }
}
