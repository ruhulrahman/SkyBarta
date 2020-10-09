<?php

namespace App\Http\Controllers\API;

use App\Follow;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function index()
    {
        $auth_id = auth('api')->user()->id;
        $users = User::where('id', $auth_id)->first();
        $following = $users->followings()->pluck('following_id');

        return Post::with(['user', 'likes', 'comments'])
                    ->whereIn('user_id', $following)
                    ->orwhere('user_id', $auth_id)
                    ->latest()
                    ->get();
    }

    public function newPost()
    {
        $today = date("Y-m-d");
        return Post::where('created_at','LIKE', "%$today%")->count();
    }

    public function totalPost()
    {
        return Post::count();
    }

    public function postByAuth(){
        $auth = auth('api')->user();
        return Post::with(['user', 'likes', 'comments'])
                    ->where('user_id', $auth->id)
                    ->orderBy('id', 'desc')
                    ->get();
    }


    public function userPost($slug){
        $user = User::where('slug', $slug)->first();
        return Post::with(['user', 'likes', 'comments'])
                    ->where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'desc' => 'required',
            'privacy_id' => 'required',
        ]);
        $user_id = auth("api")->user()->id;
        

        return Post::create([
            'user_id' => $user_id,
            'desc' => $request['desc'],
            'privacy_id' => $request['privacy_id'],
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            // 'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }


    public function show($id)
    {
        //
    }

    public function getCommentByPost($postID)
    {
        $comments = Post::findOrFail($postID)->comments()->with('user')->get();
        return $comments;
    }

    public function getCommentCountByPost()
    {
        $posts = Post::all();
        return $posts->comments()->count();
    }

    public function getLikeCountByPost($postID)
    {
        $likes = Post::findOrFail($postID)->likes()->with('user')->count();
        return $likes;
    }

    public function getLikeByPost($postID)
    {
        $likes = Post::findOrFail($postID)->likes()->with('user')->get();
        return $likes;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->validate($request, [
            'desc' => 'required',
            'privacy_id' => 'required',
        ]);

        $post->update([
            'desc' => $request['desc'],
            'privacy_id' => $request['privacy_id'],
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
    }
}
