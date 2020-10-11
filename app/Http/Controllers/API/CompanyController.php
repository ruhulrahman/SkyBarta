<?php

namespace App\Http\Controllers\API;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        $auth_id = auth("api")->user()->id;
        return Company::where('user_id', $auth_id)->orderBy('name', 'asc')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        return Company::create([
            'user_id' => $user_id,
            'name' => $request['name'],
            'address' => $request['address'],
            'email' => $request['email'],
        ]);
    }


    public function findUserByCompany($id)
    {
        return Company::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $Company = Company::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $Company->update($request->all());
    }

    public function destroy($id)
    {
        $Company = Company::findOrFail($id);
        $Company->delete();
    }

    public function show(Company $genger)
    {
        //
    }
}
