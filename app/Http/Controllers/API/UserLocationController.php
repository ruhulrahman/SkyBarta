<?php

namespace App\Http\Controllers\API;

use App\User;
use App\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserLocationController extends Controller
{
    public function index()
    {
        $auth_id = auth("api")->user()->id;
        return UserLocation::with(['division', 'district', 'thana'])->where('user_id', $auth_id)->get();
    }

    public function userLocation($slug)
    {
        $user = User::where('slug', $slug)->first();
        return UserLocation::with(['division', 'district', 'thana'])
                            ->where('user_id', $user->id)
                            ->get();
    }
    
    public function getUserlocation()
    {
        $auth_id = auth("api")->user()->id;
        return UserLocation::where('user_id', $auth_id)->first();
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'thana_id' => 'required',
            'district_id' => 'required',
            'division_id' => 'required',
        ]);

        $auth_id = auth('api')->user()->id;

        return UserLocation::create([
            'type' => $request['type'],
            'user_id' => $auth_id,
            'village_name' => $request['village_name'],
            'union_name' => $request['union_name'],
            'thana_id' => $request['thana_id'],
            'district_id' => $request['district_id'],
            'division_id' => $request['division_id'],
        ]);
    }

    public function districtByUserLocation($id){
        $query = UserLocation::findOrFail($id);
        return $query->districts()->orderBy('name')->get();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    // public function updateUserLocation(Request $request, $user_id)
    // {
    //     DB::table('user_locations')
    //         ->where('user_id', $user_id)
    //         ->update($request->all());
    // }

    public function update(Request $request, $id)
    {
        $query = UserLocation::findOrFail($id);
        $this->validate($request, [
            'type' => 'required',
            'thana_id' => 'required',
            'district_id' => 'required',
            'division_id' => 'required',
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = UserLocation::findOrFail($id);
        $query->delete();
    }
}
