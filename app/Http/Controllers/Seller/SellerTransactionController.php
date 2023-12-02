<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $transsaction = $seller->products()->whereHas('transactions')
                        ->with('transactions')
                        ->get()
                        ->pluck('transactions')
                        ->collapse();
        return $this->showAll($transsaction);
    }
}
