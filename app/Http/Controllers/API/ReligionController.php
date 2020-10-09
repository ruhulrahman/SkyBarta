<?php

namespace App\Http\Controllers\API;

use App\Religion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function index()
    {
        return Religion::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:religions|max:50',
        ]);

        return Religion::create([
            'name' => $request['name']
        ]);
    }


    public function findUserByReligion($id)
    {
        return Religion::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $Religion = Religion::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:religions,name,'.$Religion->id,
        ]);

        $Religion->update($request->all());
    }

    public function destroy($id)
    {
        $Religion = Religion::findOrFail($id);
        $Religion->delete();
    }

    public function show(Religion $genger)
    {
        //
    }
}
