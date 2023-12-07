<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\ApiController;
use App\Models\Generic;
use Illuminate\Http\Request;

class GenericController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generics = Generic::all();
        return $this->showAll($generics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:generics,name'
        ]);

        $new_generic = Generic::create($request->all());
        return $this->showOne($new_generic, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Generic $generic)
    {
        return $this->showOne($generic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Generic $generic)
    {
        $this->validate($request, [
            'name' => 'required|unique:generics,name,'.$generic->id.',id',
        ]);

        $generic->fill($request->only([
            'name'
        ]));

        if($generic->isClean){
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $generic->save();
        return $this->showOne($generic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Generic $generic)
    {
        $generic->delete();
        return $this->showOne($generic);
    }
}
