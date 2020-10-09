<?php

namespace App\Http\Controllers\API;

use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRoleController extends Controller
{
    public function index()
    {
        return UserRole::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        return UserRole::create([
            'user_id' => $request['user_id'],
            'role_id' => $request['role_id']
        ]);
    }


    public function findUserByUserRole($id)
    {
        return UserRole::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $UserRole = UserRole::findOrFail($id);
        $this->validate($request, [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $UserRole->update($request->all());
    }

    public function destroy($id)
    {
        $UserRole = UserRole::findOrFail($id);
        $UserRole->delete();
    }

    public function show(UserRole $genger)
    {
        //
    }
}
