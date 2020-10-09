<?php

namespace App\Http\Controllers\API;

use App\UserSkill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserSkillController extends Controller
{
    public function index()
    {
        return UserSkill::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $this->validate($request, [
            'skill_id' => 'required',
        ]);

        return UserSkill::create([
            'user_id' => $user_id,
            'skill_id' => $request['skill_id']
        ]);
    }


    public function findUserByUserSkill($id)
    {
        return UserSkill::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $UserSkill = UserSkill::findOrFail($id);
        $this->validate($request, [
            'skill_id' => 'required',
        ]);

        $UserSkill->update($request->all());
    }

    public function destroy($id)
    {
        $UserSkill = UserSkill::findOrFail($id);
        $UserSkill->delete();
    }

    public function show(UserSkill $genger)
    {
        //
    }
}
