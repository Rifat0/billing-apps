<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    public function __constract()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);     
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }
}
