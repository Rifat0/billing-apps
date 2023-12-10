<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductBatchLot;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBatchController extends ApiController
{
    public function index($product){
        $product = Product::with('batches')->findOrFail($product);
        return $this->showOne($product);
    }

    public function allBatchers(){
        $batches = ProductBatch::all();
        return $this->showAll($batches);
    }

    public function store(Request $request, Product $product){
        $rules = [
            'batch_no' => 'required',
            'lot_no' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'manufacturing_date' => 'date',
            'expire_date' => 'date',
        ];

        if(count($product->variations) > 0){
            $rules['product_variation_id'] = 'required|exists:product_variations,id';
        }

        $this->validate($request, $rules);

        $data = $request->all();
        $data['product_id'] = $product->id;
        $data['product_variation_id'] = $request->product_variation_id ?? null;

        $new_batch = DB::transaction(function () use ($request, $data) {
            $batch = ProductBatch::create($data);
            ProductBatchLot::create([
                'batch_id' => $batch->id,
                'lot_no' => $request->lot_no,
            ]);
            return $batch;
        }, 5);

        return $this->showOne($new_batch, 201);
    }

    public function update(Request $request, Product $product, ProductBatch $batch){
        $rules = [
            'batch_no' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'manufacturing_date' => 'date',
            'expire_date' => 'date',
        ];

        if(count($product->variations) > 0){
            $rules['product_variation_id'] = 'required|exists:product_variations,id';
        }

        $this->validate($request, $rules);

        $batch->fill($request->all());

        if($batch->isClean()){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $batch->save();
        return $this->showOne($batch);
    }

    public function changeStatus(Request $request, ProductBatch $batch){
        $this->validate($request, [
            'status' => 'required|in:'.ProductBatch::RECEIVE_PENDING.','.ProductBatch::RECEIVED.','.ProductBatch::ACTIVE.','.ProductBatch::INACTIVE.','.ProductBatch::EXPIRED.','.ProductBatch::SOLD,
        ]);

        $new_batch = DB::transaction(function () use ($request, $batch) {
            if($request->status == ProductBatch::RECEIVED){
                $batch->status = $request->status;
                $batch->receive_time = now();
            }elseif($request->status == ProductBatch::ACTIVE){
                $batch->status = $request->status;
                ProductStock::create([
                    'product_id' => $batch->product_id,
                    'product_variation_id' => $batch->product_variation_id,
                    'batch_id' => $batch->batch_no,
                    'quantity' => $batch->quantity,
                    'type' => ProductStock::IN,
                ]);
            }else{
                $batch->status = $request->status;
            }

            if($batch->isClean){
                return $this->errorResponse('You need to specify any different value to update', 422);
            }
            $batch->save();

            return $batch;
        }, 5);

        return $this->showOne($new_batch);
    }

    public function stocks(ProductBatch $batch){
        $stocks = $batch->stocks;
        return $this->showAll($stocks);
    }

    public function checkAvailableStock(ProductBatch $batch){
        $available_stock = $batch->availableStock();
        return $available_stock;
    }
}
