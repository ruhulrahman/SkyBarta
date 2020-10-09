<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        return Image::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'post_id' => 'required',
            'image' => 'required',
        ]);

        return Image::create([
            'user_id' => $request['user_id'],
            'post_id' => $request['post_id'],
            'image' => $request['image'],
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
        $img = Image::findOrFail($id);
        $this->validate($request, [
            'user_id' => 'required',
            'post_id' => 'required',
            'image' => 'required',
        ]);

        $img->update($request->all());
    }

    public function destroy($id)
    {
        $img = Image::findOrFail($id);
        $img->delete();
    }
}
