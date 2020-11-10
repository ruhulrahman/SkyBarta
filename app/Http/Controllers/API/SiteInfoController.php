<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SiteInfo;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{


    public function index()
    {
        // $user_id = auth('api')->user()->id;
        return SiteInfo::first();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $this->validate($request, [
            'title' => 'required|string',
            'short_name' => 'required|string',
            'description' => 'required',
        ]);

        return SiteInfo::create([
            'user_id' => $user_id,
            'title' => $request['title'],
            'short_name' => $request['short_name'],
            'description' => $request['description']
        ]);
    }


    public function findUserBySiteInfo($id)
    {
        return SiteInfo::find($id)->users;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $SiteInfo = SiteInfo::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|string',
            'short_name' => 'required|string',
            'description' => 'required',
        ]);

        $SiteInfo->update($request->all());
    }

    public function destroy($id)
    {
        $SiteInfo = SiteInfo::findOrFail($id);
        $SiteInfo->delete();
    }

    public function show(SiteInfo $genger)
    {
        //
    }
}
