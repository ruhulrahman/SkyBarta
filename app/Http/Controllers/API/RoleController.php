<?php

namespace App\Http\Controllers\API;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        return Role::all();
    }
    
    public function index()
    {
        return Role::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        return Role::create([
            'name' => $request['name'],
        ]);
    }


    public function findUserByRole($id)
    {
        return Role::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $Role = Role::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
        ]);

        $Role->update($request->all());
    }

    public function destroy($id)
    {
        $Role = Role::findOrFail($id);
        $Role->delete();
    }

    public function show(Role $genger)
    {
        //
    }
}
