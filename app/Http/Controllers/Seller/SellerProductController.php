<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $seller)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|min:1|integer',
            'image' => 'image',
        ]);

        $data = $request->all();
        $data['status'] = Product::UNAVIALABLE_PRODUCT;
        $data['image'] = $request->image->store();
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'min:1|integer',
            'image' => 'image',
            'status' => 'in:' . Product::AVIALABLE_PRODUCT.','.Product::UNAVIALABLE_PRODUCT,
        ]);

        $this->checkSeller($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        if($request->has('status')){
            $product->status = $request->status;

            if($product->isAvailable() && $product->categories()->count() == 0){
                return $this->errorResponse('A active product must have a category', 409);
            }
        }

        if($product->isClean()){
            return $this->errorResponse('You have to change value for update', 422);
        }

        if($request->has('image')){
            Storage::delete($product->image);
            $product->image = $request->image->store();
        }

        $product->save();

        return $this->showOne($product, 201);
        
    }

    protected function checkSeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'The specified seller is not the actual seller of the product');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);
        $product->delete();
        Storage::delete($product->image);
        return $this->showOne($product);
    }
}
