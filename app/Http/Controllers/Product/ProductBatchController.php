<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\ProductBatch;
use Illuminate\Http\Request;

class ProductBatchController extends ApiController
{
    public function index(Product $product){
        $batches = $product->batches;
        return $this->showAll($batches);
    }

    public function allBatchers(){
        $batches = ProductBatch::all();
        return $this->showAll($batches);
    }
}
