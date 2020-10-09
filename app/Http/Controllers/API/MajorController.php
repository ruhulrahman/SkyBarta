<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        return Major::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:majors',
        ]);

        return Major::create([
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
        $query = Major::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:majors,name,'.$query->id,
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = Major::findOrFail($id);
        $query->delete();
    }
}
