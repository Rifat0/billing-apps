<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\ApiController;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends ApiController
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return $this->showAll($units);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $new_unit = Unit::create($request->all());
        return $this->showOne($new_unit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return $this->showOne($unit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $unit->fill($request->only([
            'name',
        ]));

        if($unit->isClean){
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $unit->save();
        return $this->showOne($unit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return $this->showOne($unit);
    }
}
