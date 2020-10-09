<?php

namespace App\Http\Controllers\API;

use App\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        return District::with('division')->orderBy('name')->get();
    }

    public function create()
    {
        //
    }

    public function thanaByDistrict($id){
        $query = District::findOrFail($id);
        return $query->thanas()->orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:Districts',
            'division_id' => 'required',
        ]);

        return District::create([
            'name' => $request['name'],
            'division_id' => $request['division_id'],
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
        $query = District::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:districts,name,'.$query->id,
            'division_id' => 'required',
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = District::findOrFail($id);
        $query->delete();
    }
}
