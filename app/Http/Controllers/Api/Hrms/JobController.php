<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Department;
use App\Models\HRMS\Designation;
use App\Models\HRMS\Job;
use App\Models\HRMS\Skill;

class JobController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        return response()->json([
            'jobs' => Job::whereDate('start_date', '>=', $today)->whereDate('end_date', '<', $today)->with('department', 'designation', 'branch')->paginate(20),
            'branches' => Branch::orderBy('name', 'ASC')->get(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'designations' => Designation::orderBy('name', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required',
            'designation_id' => 'required',
            'branch_id'      => 'required',
            'department_id'  => 'required',
            'description'    => 'required',
        ]);

        Job::create([
            'title'          => $request->title,
            'branch_id'      => $request->branch_id,
            'department_id'  => $request->department_id,
            'designation_id' => $request->designation_id,
            'description'    => $request->description,
            'skills'          => json_encode($request->skills),
        ]);

        $today = date('Y-m-d');
        return response()->json([
            'jobs' => Job::whereDate('start_date', '>=', $today)->whereDate('end_date', '<', $today)->with('department', 'designation', 'branch')->paginate(20),
            'branches' => Branch::orderBy('name', 'ASC')->get(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'designations' => Designation::orderBy('name', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);

    }

    public function show($id)
    {
        return response()->json([
            'job' => Job::where('id', '=', $id)->with('department', 'designation', 'branch')->paginate(20),
            'branches' => Branch::orderBy('name', 'ASC')->get(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'designations' => Designation::orderBy('name', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'          => 'required',
            'designation_id' => 'required',
            'branch_id'      => 'required',
            'department_id'  => 'required',
            'description'    => 'required',
        ]);

        $job = Job::find($id);
        $job->title = $request->title;
        $job->branch_id = $request->branch_id;
        $job->department_id = $request->department_id;
        $job->designation_id = $request->designation_id;
        $job->description = $request->description;
        $job->skills = json_encode($request->skills);
        $job->save();

        $today = date('Y-m-d');
        return response()->json([
            'jobs' => Job::whereDate('start_date', '>=', $today)->whereDate('end_date', '<', $today)->with('department', 'designation', 'branch')->paginate(20),
            'branches' => Branch::orderBy('name', 'ASC')->get(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'designations' => Designation::orderBy('name', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function destroy($id)
    {
        $job = Job::where('id', $id)->first();
        $job->delete();

        $today = date('Y-m-d');
        return response()->json([
            'jobs' => Job::whereDate('start_date', '>=', $today)->whereDate('end_date', '<', $today)->with('department', 'designation', 'branch')->paginate(20),
            'branches' => Branch::orderBy('name', 'ASC')->get(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'designations' => Designation::orderBy('name', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function getSkillsByJob($jobId)
    {
        $job = Job::where('id', $jobId)->first();
        $skills = Skill::whereIn('id', json_decode($job->skill))->get()->pluck('skill_name');

        return $skills->toJson();
    }
}
