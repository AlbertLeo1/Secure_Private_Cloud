<?php

namespace App\Http\Controllers\Api\EMR\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Assessment\Assessment;

class MainController extends Controller
{
    public function assessment()
    {
        $assessments = Assessment::where('assessed_by', '=', auth('api')->id())->orderBy('status', 'ASC')->orderBy('status', 'ASC')->orderBy('assigned_date', 'ASC')->with(['assigned', 'dom', 'patient'])->get();

        return response()->json([
            'assessments' => $assessments, 
        ]);
    }

    public function dom_assessment()
    {
        $assessments = Assessment::where('assessed_by', '=', auth('api')->id())->whereNotNull('domiciliary_id')
        ->orderBy('status', 'ASC')->orderBy('assigned_date', 'ASC')
        ->with(['assigned', 'dom', 'patient'])->paginate(20);

        return response()->json([
            'assessments' => $assessments, 
        ]);
    }

    public function index()
    {
        $assessments = Assessment::where('assessed_by', '=', auth('api')->id())->orderBy('status', 'ASC')
        ->orderBy('assigned_date', 'ASC')
        ->with(['assigned', 'dom', 'patient'])->paginate(20);

        return response()->json([
            'assessments' => $assessments,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $assessment = Assessment::where('assessed_by', '=', auth('api')->id())->whereNotNull('domiciliary_id')
        ->orderBy('status', 'ASC')->orderBy('assigned_date', 'ASC')
        ->with(['assigned', 'dom', 'patient'])->first();
        return response()->json([
            'assessment' => $assessment, 
        ]);
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
