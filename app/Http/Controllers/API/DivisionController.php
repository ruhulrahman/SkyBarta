<?php

namespace App\Http\Controllers\API;

use App\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        return Division::orderBy('name')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:Divisions',
        ]);

        return Division::create([
            'name' => $request['name'],
        ]);
    }

    public function districtByDivision($id){
        $query = Division::findOrFail($id);
        return $query->districts()->orderBy('name')->get();
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
        $query = Division::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:divisions,name,'.$query->id,
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = Division::findOrFail($id);
        $query->delete();
    }
}
