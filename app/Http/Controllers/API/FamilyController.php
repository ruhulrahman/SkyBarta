<?php

namespace App\Http\Controllers\API;

use App\Family;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index()
    {
        return Family::with('user')->orderBy('id', 'desc')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'desc' => 'required',
        ]);
        $user_id = auth("api")->user()->id;
        

        return Family::create([
            'user_id' => $user_id,
            'desc' => $request['desc'],
            // 'created_at' => date('Y-m-d H:i:s'),
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
        $Family = Family::findOrFail($id);
        $this->validate($request, [
            'desc' => 'required',
        ]);

        $Family->update([
            'desc' => $request['desc'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function destroy($id)
    {
        $Family = Family::findOrFail($id);
        $Family->delete();
    }
}
