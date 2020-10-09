<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PresentAddress;
use Illuminate\Http\Request;

class PresentAddressController extends Controller
{
    public function index()
    {
        return PresentAddress::all();
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

        return PresentAddress::create([
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
        $pre = PresentAddress::findOrFail($id);
        $this->validate($request, [
            'user_id' => 'required',
            'division' => 'required',
            'district' => 'required',
            'police_station' => 'required',
            'postal' => 'required',
            'village' => 'required',
        ]);

        $pre->update($request->all());
    }

    public function destroy($id)
    {
        $pre = PresentAddress::findOrFail($id);
        $pre->delete();
    }
}
