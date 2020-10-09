<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Thana;
use Illuminate\Http\Request;

class ThanaController extends Controller
{
    public function index()
    {
        return Thana::with(['district', 'division'])->orderBy('name')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:Thanas',
            'district_id' => 'required',
        ]);

        return Thana::create([
            'name' => $request['name'],
            'district_id' => $request['district_id'],
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
        $query = Thana::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:thanas,name,'.$query->id,
            'district_id' => 'required',
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = Thana::findOrFail($id);
        $query->delete();
    }
}
