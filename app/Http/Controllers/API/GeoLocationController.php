<?php

namespace App\Http\Controllers\API;

use App\GeoLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeoLocationController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        abort_unless(\Gate::allows('company_create'), 403);
        $company = GeoLocation::create($request->all());
        return redirect()->route('admin.companies.index');
    }

    public function show(GeoLocation $geoLocation)
    {
        //
    }


    public function edit(GeoLocation $geoLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GeoLocation  $geoLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeoLocation $geoLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GeoLocation  $geoLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeoLocation $geoLocation)
    {
        //
    }
}
