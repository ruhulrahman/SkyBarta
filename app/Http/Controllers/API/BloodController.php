<?php

namespace App\Http\Controllers\API;

use App\Blood;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BloodController extends Controller
{

    public function index()
    {
        return Blood::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:bloods|max:50',
        ]);

        return Blood::create([
            'name' => $request['name']
        ]);
    }


    public function findUserByBlood($id)
    {
        return Blood::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $blood = Blood::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:bloods,name,'.$blood->id,
        ]);

        $blood->update($request->all());
    }

    public function destroy($id)
    {
        $blood = Blood::findOrFail($id);
        $blood->delete();
    }
}
