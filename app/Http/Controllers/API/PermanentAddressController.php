<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PermanentAddress;
use Illuminate\Http\Request;

class PermanentAddressController extends Controller
{
    public function index()
    {
        return PermanentAddress::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'division' => 'required',
            'district' => 'required',
            'police_station' => 'required',
            'postal' => 'required',
            'village' => 'required',
        ]);

        return PermanentAddress::create([
            'user_id' => $request['user_id'],
            'division' => $request['division'],
            'district' => $request['district'],
            'police_station' => $request['police_station'],
            'postal' => $request['postal'],
            'village' => $request['village'],
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
        $perm = PermanentAddress::findOrFail($id);
        $this->validate($request, [
            'user_id' => 'required',
            'division' => 'required',
            'district' => 'required',
            'police_station' => 'required',
            'postal' => 'required',
            'village' => 'required',
        ]);

        $perm->update($request->all());
    }

    public function destroy($id)
    {
        $perm = PermanentAddress::findOrFail($id);
        $perm->delete();
    }
}
