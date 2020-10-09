<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    public function index()
    {
        return Profession::all();
    }

    public function create()
    {
        //
    }

    public function getuserbyprofession($prof_id){

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:professions',
        ]);

        return Profession::create([
            'name' => $request['name'],
        ]);
    }


    public function show($id)
    {
        //
    }

    public function findUserByprofession($id)
    {
        return Profession::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $pro = Profession::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:professions,name,'.$pro->id,
        ]);

        $pro->update($request->all());
    }

    public function destroy($id)
    {
        $pro = Profession::findOrFail($id);
        $pro->delete();
    }
}
