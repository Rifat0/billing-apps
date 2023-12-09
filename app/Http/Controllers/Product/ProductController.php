<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    /**
     * Display the specified resource.
     */
    public function show($productId)
    {
        $product = Product::with('variations')->findOrFail($productId);
        return $this->showOne($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' =>  'image',
            'name' =>  'required',
            'company' => 'required',
            'generic' => 'required',
        ]);

        if($request->has('variation')){
            $this->validate($request, [
                'variation' => 'array',
                'variation.*.image' => 'image',
                'variation.*.name' => 'required',
                'variation.*.unit' => 'required',
            ]);
        }

        $data = [
            'name' => $request->name,
            'description' => $request->name,
            'company_id' => $request->company,
            'generic_id' => $request->generic,
            'unit_id' => $request->unit,
        ];

        if($request->has('image')){
            $data['image'] = $request->image->store();
        }

        $new_product = DB::transaction(function () use ($request, $data) {
            $product = Product::create($data);

            if($request->has('variation')){
                foreach($request->variation as $variation){
                    $data = [
                        'name' => $variation['name'],
                        'product_id' => $product->id,
                        'unit_id' => $variation['unit'],
                    ];

                    if(isset($variation['image'])){
                        $data['image'] = $variation['image']->store();
                    }
                    ProductVariation::create($data);
                }
            }
            return $product->load('variations');
        }, 5);

        if(!empty($new_product)){
            return $this->showOne($new_product, 201);
        }
        return $this->errorResponse('Something went wrong', 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'image' =>  'image',
            'name' =>  'required',
            'company' => 'required',
            'generic' => 'required',
        ]);

        $product->fill($request->only([
            'name' => $request->name,
            'description' => $request->name,
            'company_id' => $request->company,
            'generic_id' => $request->generic,
            'unit_id' => $request->unit,
        ]));

        if($request->has('image') && $request->hasFile('image')){
            if(!empty($product->image)){
                $pathinfo = pathinfo($product->image);
                $image_name = $pathinfo['filename'].'.'.$pathinfo['extension'];
                if(Storage::disk('image')->exists($image_name)){
                    Storage::disk('image')->delete($image_name);
                }
            }
            $product->image = $request->image->store();
        }

        if($product->isClean){
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(!empty($product->image)){
            $pathinfo = pathinfo($product->image);
            $image_name = $pathinfo['filename'].'.'.$pathinfo['extension'];
            if(Storage::disk('image')->exists($image_name)){
                Storage::disk('image')->delete($image_name);
            }
        }
        $product->delete();
        return $this->showOne($product);
    }
}
