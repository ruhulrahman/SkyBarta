<?php

namespace App\Http\Controllers\API;

use App\Relation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    public function index()
    {
        return Relation::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:relations|max:50',
        ]);

        return Relation::create([
            'name' => $request['name']
        ]);
    }


    public function findUserByRelation($id)
    {
        return Relation::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $Relation = Relation::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:relations,name,'.$Relation->id,
        ]);

        $Relation->update($request->all());
    }

    public function destroy($id)
    {
        $Relation = Relation::findOrFail($id);
        $Relation->delete();
    }

    public function show(Relation $genger)
    {
        //
    }
}
