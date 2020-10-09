<?php

namespace App\Http\Controllers\API;

use App\Gender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenderController extends Controller
{
    public function index()
    {
        return Gender::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:genders|max:50',
        ]);

        return Gender::create([
            'name' => $request['name']
        ]);
    }


    public function findUserByGender($id)
    {
        return Gender::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $Gender = Gender::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:genders,name,'.$Gender->id,
        ]);

        $Gender->update($request->all());
    }

    public function destroy($id)
    {
        $Gender = Gender::findOrFail($id);
        $Gender->delete();
    }

    public function show(Gender $genger)
    {
        //
    }

    
}
