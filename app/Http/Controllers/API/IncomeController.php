<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return Income::with('user')->orderBy('id', 'desc')->get();
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
        

        return Income::create([
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
        $Income = Income::findOrFail($id);
        $this->validate($request, [
            'desc' => 'required',
        ]);

        $Income->update([
            'desc' => $request['desc'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function destroy($id)
    {
        $Income = Income::findOrFail($id);
        $Income->delete();
    }
}
