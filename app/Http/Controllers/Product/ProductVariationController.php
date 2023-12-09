<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class ProductVariationController extends ApiController
{
    /**
     * Display the specified resource.
     */
    public function show(ProductVariation $variation)
    {
        $variation->load('product');
        return $this->showOne($variation);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image',
            'name' => 'required',
            'unit' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'product_id' => $request->product,
            'unit_id' => $request->unit,
        ];

        if($request->has('image')){
            $data['image'] = $request->image->store();
        }

        $new_variation = ProductVariation::create($data);

        return $this->showOne($new_variation, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariation $variation)
    {
        $this->validate($request, [
            'product' => 'required',
            'image' => 'image',
            'name' => 'required',
            'unit' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'product_id' => $request->product,
            'unit_id' => $request->unit,
        ];

        $variation->fill($request->only($data));

        if($request->has('image') && $request->hasFile('image')){
            if(!empty($variation->image)){
                $pathinfo = pathinfo($variation->image);
                $image_name = $pathinfo['filename'].'.'.$pathinfo['extension'];
                if(Storage::disk('image')->exists($image_name)){
                    Storage::disk('image')->delete($image_name);
                }
            }
            $variation->image = $request->image->store();
        }

        if($variation->isClean){
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $variation->save();
        return $this->showOne($variation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariation $variation)
    {
        if(!empty($variation->image)){
            $pathinfo = pathinfo($variation->image);
            $image_name = $pathinfo['filename'].'.'.$pathinfo['extension'];
            if(Storage::disk('image')->exists($image_name)){
                Storage::disk('image')->delete($image_name);
            }
        }
        $variation->delete();
        return $this->showOne($variation);
    }
}
