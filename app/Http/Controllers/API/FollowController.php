<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\User;
use App\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function index()
    {
        $auth_id = auth('api')->user()->id;
        $followerCheck = Follow::where('follower_id', $auth_id)->first();
        if($followerCheck){
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getfollow()
    {
        $auth_id = auth('api')->user()->id;
        return Follow::where('follower_id', $auth_id)->get();
    }

    public function create()
    {
        //
    }


    public function getFollower($user_slug)
    {
        $user_id = User::where('slug', $user_slug)->first()->id;
        $auth_id = auth('api')->user()->id;
        $followerCheck = Follow::where('following_id', $user_id)
                        ->where('follower_id', $auth_id)
                        ->count();
        if($followerCheck>0){
            return 'true';
        }else{
            return 'false';
        }
    }

    public function followerCheckByAuth()
    {
        $user_id = User::pluc('id');
        $auth_id = auth('api')->user()->id;
        $followerCheck = Follow::where('following_id', $user_id)
                        ->where('follower_id', $auth_id)
                        ->count();
        if($followerCheck>0){
            return 'true';
        }else{
            return 'false';
        }
    }

    // public function getFollowPost()
    // {
    //     $auth_id = auth('api')->user()->id;
    //     $follow = Follow::where('follower_id', $auth_id)->first();
        
    //     return $follow->followingPosts()->get();
    // }


    public function authInfo($user_slug)
    {
        $user_id = User::where('slug', $user_slug)->first()->id;
        $auth_id = auth('api')->user()->id;
        if($user_id === $auth_id){
            return 'true';
        }else{
            return 'false';
        }
    }


    public function followerCount($user_slug)
    {
        $user = User::where('slug', $user_slug)->first();
        return Follow::where('following_id', $user->id)->count();
    }


    public function followingCount($user_slug)
    {
        $user = User::where('slug', $user_slug)->first();
        return Follow::where('follower_id', $user->id)->count();
    }


    public function followerCountInTimeline()
    {
        $user_id = auth('api')->user()->id;
        return Follow::where('following_id', $user_id)->get();
    }


    public function followingCountInTimeline()
    {
        $user_id = auth('api')->user()->id;
        return Follow::where('follower_id', $user_id)->get();
    }



    public function store(Request $request)
    {
        $auth_id = auth('api')->user()->id;

        $followCheck = Follow::where('follower_id', $auth_id)->first();
        if($followCheck){
            Follow::where('follower_id', $auth_id)->delete();
        }else{
            Follow::create([
                'follower_id' => $auth_id,
                'following_id' => $request->id,
            ]);

        }
    }



    public function followerCreate($user_slug)
    {
        $user_id = User::where('slug', $user_slug)->first()->id;
        $auth_id = auth('api')->user()->id;

        $followCheck = Follow::where('follower_id', $auth_id)
                            ->where('following_id', $user_id)
                            ->first();
        if($followCheck){
            Follow::where('follower_id', $auth_id)
                    ->where('following_id', $user_id)
                    ->delete();
        }else{
            Follow::create([
                'follower_id' => $auth_id,
                'following_id' => $user_id,
            ]);

        }
        return Follow::where('follower_id', $auth_id)->count();
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

    }

    public function destroy($id)
    {
        $Follow = Follow::findOrFail($id);
        $Follow->delete();
    }
}
