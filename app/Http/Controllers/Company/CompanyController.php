<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Company;

class CompanyController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return $this->showAll($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $new_company = Company::create($request->all());
        return $this->showOne($new_company, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return $this->showOne($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name'          =>  'required'
        ]);

        $company->fill($request->only([
            'name',
            'address'
        ]));

        if($company->isClean){
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $company->save();
        return $this->showOne($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return $this->showOne($company);
    }
}
