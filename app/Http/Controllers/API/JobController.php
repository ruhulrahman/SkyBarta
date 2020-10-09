<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Job;
use App\Privacy;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $auth_id = auth("api")->user()->id;
        return Job::with(['user','category','privacy','company'])->where('user_id', $auth_id)->orderBy('id', 'desc')->get();
    }


    public function findJob()
    {
        $privacies = Privacy::all();
        $private = "";
        foreach ($privacies as $privacy) {
            if($privacy->name == "Private"){
                $private = $privacy->id;
            }
        }
        return Job::with(['user','category','privacy','company'])
                    ->where('privacy_id', '!=', $private)
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
            'company_id' => 'required',
            'title' => 'required|max:50',
            'description' => 'required',
            'salary_range' => 'nullable|max:25',
            'deadline' => 'required|date',
            'category_id' => 'required',
            'privacy_id' => 'required',
        ]);

        $user_id = auth("api")->user()->id;

        return Job::create([
            'user_id' => $user_id,
            'company_id' => $request['company_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'salary_range' => $request['salary_range'],
            'deadline' => $request['deadline'],
            'category_id' => $request['category_id'],
            'privacy_id' => $request['privacy_id'],
        ]);
    }


    public function show($id)
    {
        return Job::with(['user','category','privacy','company'])->where('id', $id)->orderBy('id', 'desc')->get();
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $this->validate($request, [
            'company_id' => 'required',
            'title' => 'required|max:50',
            'description' => 'required',
            'salary_range' => 'nullable|max:25',
            'deadline' => 'required|date',
            'category_id' => 'required',
            'privacy_id' => 'required',
        ]);

        $job->update($request->all());
        // $job->update([
        //     'company_name' => $request['company_name'],
        //     'title' => $request['title'],
        //     'description' => $request['description'],
        //     'salary_range' => $request['salary_range'],
        //     'deadline' => $request['deadline'],
        //     'category_id' => $request['category_id'],
        //     'privacy_id' => $request['privacy_id'],
        // ]);
    }

    public function destroy($id)
    {
        $query = Job::findOrFail($id);
        $query->delete();
    }
}
