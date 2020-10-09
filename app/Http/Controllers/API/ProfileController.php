<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        return Profile::all();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'education_id' => 'required',
            'pass_year' => 'required',
            'profession_id' => 'required',
        ]);

        return Profile::create([
            'user_id' => $request['user_id'],
            'education_id' => $request['education_id'],
            'pass_year' => $request['pass_year'],
            'profession_id' => $request['profession_id'],
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
        $pro = Profile::findOrFail($id);
        $this->validate($request, [
            'user_id' => 'required',
            'education_id' => 'required',
            'pass_year' => 'required',
            'profession_id' => 'required',
        ]);

        $pro->update($request->all());
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();
    }
}
