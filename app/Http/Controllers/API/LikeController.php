<?php

namespace App\Http\Controllers\API;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function index()
    {
        return Like::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function newLike()
    {
        $today = date("Y-m-d");
        return Like::where('created_at','LIKE', "%$today%")->count();
    }

    public function totalLike()
    {
        return Like::count();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required',
        ]);

        $user_id = auth("api")->user()->id;

        return Like::create([
            'post_id' => $request['post_id'],
            'user_id' => $user_id,
        ]);
    }

    public function likeCreate($post_id){
        $auth = auth('api')->user();

        $likecheck = Like::where('user_id', $auth->id)
                            ->where('post_id', $post_id)->first();
        if($likecheck){
            Like::where('user_id', $auth->id)
                        ->where('post_id', $post_id)
                        ->delete();
        }else{
            Like::create([
                'post_id' => $post_id,
                'user_id' => $auth->id,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        }


        // $auth = auth('api')->user();
        // $like = Like::all();
        // Like::create([
        //     'post_id' => $post_id,
        //     'user_id' => $auth->id,
        //     'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        // ]);
        // foreach ($like as $value) {
        //     if($value->user_id == $auth->id && $value->post_id == $post_id){
        //         Like::where('user_id', $auth->id)
        //                 ->where('post_id', $post_id)->first()->delete();
        //     }else{
        //         Like::create([
        //             'post_id' => $post_id,
        //             'user_id' => $auth->id,
        //             'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        //         ]);
        //     }
        // }
        
        return Like::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function likeCount($post_id){
        // $auth = auth('api')->user();
        return Like::where('post_id', $post_id)->count();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update($post_id)
    {
        $auth = auth('api')->user();
        $like = Like::where('post_id', $post_id)->where('user_id', $auth);

        $like->update(['count' => 0]);
    }

    public function destroy($id)
    {
        $like = Like::findOrFail($id);
        $like->delete();
    }
}
