<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FriendController extends Controller
{
    public function index()
    {
        return Friend::with('user')->orderBy('id', 'desc')->get();
    }

    public function friendRequest(){
        $auth_id = auth('api')->user()->id;
        // return Friend::find($auth_id)->requests()->orderBy('id', 'desc')->get();
        return DB::table('users')
            ->join('friends', 'users.id', '=', 'friends.request_id')
            ->select('users.*', 'friends.id as fnd_id', 'friends.request_id as request_id', 'friends.accept_id as accept_id')
            ->where('friends.user_id', $auth_id)
            ->orderBy('friends.id', 'desc')
            ->get();
        // return Friend::with('request')
        //             ->where('user_id', $auth_id)
        //             ->get();
    }
    public function friendList(){
        $auth_id = auth('api')->user()->id;
        // return Friend::find($auth_id)->requests()->orderBy('id', 'desc')->get();
        return DB::table('users')
            ->join('friends', 'users.id', '=', 'friends.accept_id')
            ->select('users.*', 'friends.id as fnd_id', 'friends.request_id as request_id', 'friends.accept_id as accept_id')
            ->where('friends.user_id', $auth_id)
            ->orderBy('friends.id', 'desc')
            ->get();
        // return Friend::with('request')
        //             ->where('user_id', $auth_id)
        //             ->get();
    }

    public function confirmRequest($id){
        $fnd = Friend::findOrFail($id);

        $fnd->update([
            'request_id' => 0,
            'accept_id' => $fnd->request_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function findFriend(){
        $auth_id = auth('api')->user()->id;        
        $friends = DB::table('friends')->get();
        foreach ($friends as $fnd) {            
            $user = User::where('id','!=', $auth_id)
            ->where('id','!=', $fnd->user_id)
            ->get();
        }
        return $user;
        // Friend::where()->get();
        
        // $user = User::where('id', '!=', $auth_id)->get();

        // $fnd = Friend::where('user_id', '=', $auth_id)
        // ->orderBy('id', 'desc')
        // ->get();

        // $fnd->user()->where('id', '!=', $auth_id)->where('id', '!=', $fnd->accept_id)->get();

        // return $fnd;

        // return DB::table('users')
        //     ->where('users.id', '!=', $auth_id)
        //     ->get();


        // return DB::table('users')
        //     ->join('friends', 'users.id', '!=', 'friends.request_id')
        //     ->leftJoin('friends', 'users.id', '!=', 'friends.accept_id')
        //     ->select('users.*')
        //     ->diff('users.id',  $auth_id)
        //     ->where('friends.user_id', '!=',  $auth_id)
        //     ->get();
    }

    public function addFriend($user_id){
        $request_id = auth("api")->user()->id;
        

        return Friend::create([
            'user_id' => $user_id,
            'request_id' => $request_id,
            // 'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'desc' => 'required',
        ]);
        $user_id = auth("api")->user()->id;
        

        return Friend::create([
            'user_id' => $user_id,
            'desc' => $request['desc'],
            // 'created_at' => date('Y-m-d H:i:s'),
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
        $Friend = Friend::findOrFail($id);
        $this->validate($request, [
            'desc' => 'required',
        ]);

        $Friend->update([
            'desc' => $request['desc'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function destroy($id)
    {
        $Friend = Friend::findOrFail($id);
        $Friend->delete();
    }
}
