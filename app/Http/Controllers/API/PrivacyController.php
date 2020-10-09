<?php

namespace App\Http\Controllers\API;

use App\Privacy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{

    public function index()
    {
        return Privacy::orderby('name', 'asc')->get();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:privacies',
        ]);

        return Privacy::create([
            'name' => $request['name'],
        ]);
    }


    public function show(Privacy $privacy)
    {
        //
    }


    public function edit(Privacy $privacy)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $query = Privacy::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:privacies,name,'.$query->id,
        ]);

        $query->update($request->all());
    }

    public function destroy($id)
    {
        $query = Privacy::findOrFail($id);
        $query->delete();
        // return response()->json("ok");
    }
}
