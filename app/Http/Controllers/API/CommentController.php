<?php

namespace App\Http\Controllers\API;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function index()
    {
        return Comment::all();
    }


    public function newComment()
    {
        $today = date("Y-m-d");
        return Comment::where('created_at','LIKE', "%$today%")->count();
    }

    public function totalComment()
    {
        return Comment::count();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required',
            'comment' => 'required',
        ]);
        $user_id = auth("api")->user()->id;
        Comment::create([
            'post_id' => $request['post_id'],
            'user_id' => $user_id,
            'comment' => $request['comment'],
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => date('Y-m-d H:i:s'),
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
        $comment = Comment::findOrFail($id);
        $this->validate($request, [
            'post_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        $comment->update($request->all());
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }
}
