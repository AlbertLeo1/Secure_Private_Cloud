<?php

namespace App\Http\Controllers\Api\EMR\Nursing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Patient;
use App\Models\EMR\NursingTask;
use App\Models\EMR\Frequency;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json([]);
    }

    public function initials()
    {
        return response()->json([
            'patients' => Patient::orderBy('first_name', 'ASC')->get(),
            'tasks' => NursingTask::select('id', 'icons', 'name')->where('status', '=', 1)->orderBy('name', 'ASC')->get(),
            'frequencies' => Frequency::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
