<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        // $auth_id = auth('api')->user()->id;
        // $follow = Follow::where('follower_id', $auth_id)->get();
        return User::with(['blood', 'profession', 'follow'])->get();
        // $this->authorize('isAdmin');
        // if (Gate::allows('isAdmin') || Gate::allows('isSuperAdmin') || Gate::allows('isAuthor')) {
        //     // The current user can edit
        //     // return User::with(['blood', 'profession'])->latest()->paginate(20);
        //     return User::with(['blood', 'profession'])->get();
        // }
    }


    public function userten()
    {
        return User::with(['blood', 'profession'])->latest()->paginate(10);
    }

    public function user_auth_id()
    {
        return auth("api")->user()->id;
        // return User::with('where', $user_id)->pluck('id');
    }

    public function newFemaleUser()
    {
        $today = date("Y-m-d");
        return User::where('gender_id','f')
                    ->where('created_at','LIKE', "%$today%")
                    ->count();
    }

    public function newMaleUser()
    {
        $today = date("Y-m-d");
        return User::where('gender_id','m')
                    ->where('created_at','LIKE', "%$today%")
                    ->count();
    }

    public function totalFemaleUser()
    {
        return User::where('gender_id','f')->count();
    }

    public function totalMaleUser()
    {
        return User::where('gender_id','m')->count();
    }

    public function newUser()
    {
        $today = date("Y-m-d");
        if (Gate::allows('isAdmin') || Gate::allows('isSuperAdmin') || Gate::allows('isAuthor')) {
            return User::where('created_at','LIKE', "%$today%")->count();
        }
    }

    public function totalUser()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isSuperAdmin') || Gate::allows('isAuthor')) {
            return User::count();
        }
    }

    public function people()
    {        
        return DB::table('users')
        ->join('professions', 'users.profession_id', '=', 'professions.id')
        ->join('bloods', 'users.blood_id', '=', 'bloods.id')
        ->select('users.*', 'professions.name as profession_name', 'bloods.name as blood_name')
        ->orderBy('users.name', 'asc')
        ->get();
    }

    public function search()
    {
        if($search = \Request::get('q')){
            $users = DB::table('users')
                        ->join('professions', 'users.profession_id', '=', 'professions.id')
                        ->join('bloods', 'users.blood_id', '=', 'bloods.id')
                        ->select('users.*', 'professions.name as profession_name', 'bloods.name as blood_name')
                        ->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orderBy('users.name', 'asc')
                        ->get();
        }else{
            $users = DB::table('users')
            ->join('professions', 'users.profession_id', '=', 'professions.id')
            ->join('bloods', 'users.blood_id', '=', 'bloods.id')
            ->select('users.*', 'professions.name as profession_name', 'bloods.name as blood_name')
            ->orderBy('users.name', 'asc')
            ->get(); 
        }
        return $users;
    }

    public function findPeople()
    {
        if($search = \Request::get('q')){
            $users = User::where('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', $search)
                            ->orWhere('mobile', 'LIKE', $search)
                            ->get();
        }else{
            $users = ['message' => 'Please role_id something'];
        }
        return $users;
    }

    public function findUserByprofession(Request $request){
        return DB::table('users')
                        ->join('professions', 'users.profession_id', '=', 'professions.id')
                        ->join('bloods', 'users.blood_id', '=', 'bloods.id')
                        ->select('users.*', 'professions.name as profession_name', 'bloods.name as blood_name')
                        ->where('professions.id', $request->profession_id)
                        ->orderBy('users.name', 'asc')
                        ->get();  
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users|max:50',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|min:6|max:255',
            'quote' => 'min:3|max:100',
            'role_id' => 'required',
            'gender_id' => 'required',
            'dob' => 'required',
            'religion_id' => 'required',
        ]);

        $slug = preg_replace('/\s+/', '', $request['name']);

        $user_id = DB::table('users')->insertGetId([
            'name' => $request['name'],
            // 'slug' => rand(1000,1000000000),
            'slug' => $slug.time("dmYhms"),
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'],
            'aboutme' => $request['aboutme'],
            'm_income' => $request['m_income'],
            'fam_members' => $request['fam_members'],
            'gender_id' => $request['gender_id'],
            'dob' => $request['dob'],
            'hobby' => $request['hobby'],
            'religion_id' => $request['religion_id'],
            'relation_id' => $request['relation_id'],
            'photo' => 'boy.png',
        ]);

        // UserLocation::create([
        //     'user_id' => $user_id,
        // ]);
    }

    public function timeline()
    {
        return auth("api")->user();
        // $auth_id = auth("api")->user()->id;
        // return User::with(['blood', 'profession','gender','religion','relation'])->where('id', $auth_id)->first();
    }

    public function userTimeInfo()
    {
        $auth_id = auth("api")->user()->id;
        return User::with(['blood', 'profession','gender','religion','relation'])->where('id', $auth_id)->get();
    }

    public function profile($slug)
    {
        return User::with(['blood', 'profession','gender','religion','relation'])->where('slug', $slug)->get();
    }

    public function usersInfo($slug)
    {
        // $auth_id = auth("api")->user()->id;
        return User::with(['blood', 'profession','gender','religion','relation'])->where('slug', $slug)->get();
        // return auth("api")->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth("api")->user();

        $this->validate($request, [
            'name' => 'required|string|max:50|unique:users,name,'.$user->id,
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'mobile' => 'required|numeric|unique:users,mobile,'.$user->id,
            'slug' => 'required|string|unique:users,slug,'.$user->id,
            'password' => 'sometimes|required|min:6|max:255',
            'dob' => 'required',
        ]);

        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.'.explode("/", explode(":", substr($request->photo, 0, strpos($request->photo, ';'))) [1])[1];
            Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        
        $user->update($request->all());
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:50|unique:users,name,'.$user->id,
            'slug' => 'required|string|max:191|unique:users,slug,'.$user->id,
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6|max:255',
            'role_id' => 'required',
            'gender_id' => 'required',
            'dob' => 'required',
            'religion_id' => 'required',
        ]);

        $user->update($request->all());
        //return ['message' => 'User updated'];
    }

    public function findFriend(){
        $auth_id = auth('api')->user()->id;

        $fnd = Friend::where('accep', '=', $auth_id)
                ->orderBy('id', 'desc')
                ->get();
        $fnd->user()->where('id', '!=', $auth_id)->where('id', '!=', $fnd->accept_id)->get();

        return $fnd;
     
        // return User::with(['friends'])
        //             ->where('id', '!=', $auth_id)
        //             ->orderBy('id', 'desc')
        //             ->get();
    }


    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        //Delete the user
        $user->delete();

        return ['message' => 'User Deleted'];
    }
}
