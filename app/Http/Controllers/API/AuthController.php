<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required'],
            'gender_id' => ['required'],
            'religion_id' => ['required'],
            'dob' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $validate['password'] =  bcrypt($request->password);

        $user = User::create($validate);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'accessToken' => $accessToken]);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message' => 'Invalid credential']);
        }else{
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response(['user' => auth()->user(), 'accessToken' => $accessToken]);
        }
    }
}
