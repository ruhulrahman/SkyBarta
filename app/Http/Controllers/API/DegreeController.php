<?php

namespace App\Http\Controllers\API;

use App\Degree;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    public function index()
    {
        return Degree::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:degrees',
        ]);

        return Degree::create([
            'name' => $request['name'],
        ]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $degree = Degree::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:degrees,name,'.$degree->id,
        ]);

        $degree->update($request->all());
    }

    public function destroy($id)
    {
        $query = Degree::findOrFail($id);
        $query->delete();
    }
}
