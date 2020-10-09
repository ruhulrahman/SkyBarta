<?php

namespace App\Http\Controllers\API;

use App\Skill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return Skill::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:skills|max:50',
        ]);

        return Skill::create([
            'name' => $request['name']
        ]);
    }


    public function findUserBySkill($id)
    {
        return Skill::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $Skill = Skill::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:skills,name,'.$Skill->id,
        ]);

        $Skill->update($request->all());
    }

    public function destroy($id)
    {
        $Skill = Skill::findOrFail($id);
        $Skill->delete();
    }

    public function show(Skill $genger)
    {
        //
    }
}
