<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
