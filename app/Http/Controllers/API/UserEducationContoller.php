<?php

namespace App\Http\Controllers\API;

use App\User;
use App\UserEducation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEducationContoller extends Controller
{
    public function index()
    {
        $auth_id = auth('api')->user()->id;
        return UserEducation::with(['user', 'degree', 'major'])
                            ->where('user_id', $auth_id)
                            ->orderby('passing_year', 'desc')
                            ->get();
    }


    public function userEducation($slug)
    {
        $user = User::where('slug', $slug)->first();
        return UserEducation::with(['user', 'degree', 'major'])
                            ->where('user_id', $user->id)
                            ->orderby('passing_year', 'desc')
                            ->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'degree_id' => 'required',
            'major_id' => 'required',
            'passing_year' => 'required|integer|min:1950|max:2050',
        ]);

        $auth_id = auth('api')->user()->id;

        return UserEducation::create([
            'user_id' => $auth_id,
            'degree_id' => $request['degree_id'],
            'major_id' => $request['major_id'],
            'passing_year' => $request['passing_year'],
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
        $query = UserEducation::findOrFail($id);
        $this->validate($request, [
            'degree_id' => 'required',
            'major_id' => 'required',
            'passing_year' => 'required|integer',
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = UserEducation::findOrFail($id);
        $query->delete();
    }
}
