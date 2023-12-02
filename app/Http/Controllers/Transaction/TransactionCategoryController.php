<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionCategoryController extends ApiController
{
    public function index(Transaction $transaction)
    {
        $categories = $transaction->product->categories;
        return $this->showAll($categories);
    }
}
