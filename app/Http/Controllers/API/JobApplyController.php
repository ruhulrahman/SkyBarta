<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\JobApply;
use Illuminate\Http\Request;

class JobApplyController extends Controller
{
    public function index()
    {
        return JobApply::with('user')->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $user_id = auth("api")->user()->id;

        return JobApply::create([
            'job_id' => $request['job_id'],
            'applier_id' => $user_id,
        ]);
    }

    public function show($job_id)
    {
        $user_id = auth("api")->user()->id;

        return JobApply::create([
            'job_id' => $job_id,
            'applier_id' => $user_id,
        ]);
    }

    public function jobapplyCheck($jobid)
    {
        $user_id = auth("api")->user()->id;

        return JobApply::where('job_id', $jobid)->where('applier_id', $user_id)->pluck('job_id');
    }

    public function jobapplicants($jobid)
    {
        return JobApply::with('user')->where('job_id', $jobid)->get();
    }

    public function destroy($id)
    {
        $query = JobApply::findOrFail($id);
        $query->delete();
    }
}
