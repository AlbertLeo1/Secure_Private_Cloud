<?php

namespace App\Http\Controllers\Api\EMR\Nursing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EMR\Batch;
use App\Models\EMR\BatchActivity;
use App\Models\EMR\Patient;
use App\Models\EMR\PatientTask;

class PatientTaskController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'start_date' => 'required|date',
            'task_id' => 'required|numeric',
            'repeating' => 'required|numeric|nullable',
            'frequency_id' => 'sometimes|numeric|nullable',
            'quantity' => 'sometimes|numeric|nullable',
            'domiciliary' => 'sometimes|numeric|nullable',
        ]);
        
        $patient_task = PatientTask::create([
            'patient_id' => $request->input('patient_id'), 
            'task_id' => $request->input('task_id'), 
            'domiciliary' => $request->input('domiciliary'), 
            'details' => $request->input('details'), 
            'start_date' => $request->input('start_date'), 
            'end_date' => $request->input('end_date'), 
            'created_by' => auth('api')->id(), 
            'updated_by' => auth('api')->id(), 
            'frequency_id' => $request->input('frequency_id'),
            'quantity' => $request->input('quantity'),
            'repeating' => $request->input('repeating'), 
        ]);

        return response()->json([
            'patient' => Patient::where('id', '=', $patient_task->patient_id)->first(),
            'message' => 'Task created successfully',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'tasks' => PatientTask::where('patient_id', '=', $id)->with(['task', 'frequency'])->paginate(10),
        ]);
    }

    public function domiciliary($id)
    {
        $patient = Patient::findorfail($id);
        $task_list = [];
        $patient_tasks = PatientTask::where([['patient_id', $patient->id],['domiciliary', 1] ])->whereDate('end_date', '<=', date('Y-m-d'))->OrWhereNull('end_date')->with('task')->get();

        foreach ($patient_tasks as $patient_task){
            $batch_activites = BatchActivity::select('batch_id')->where('patient_task_id', '=', $patient_task->id)->get();
            $batch_count = Batch::whereIn('id', $batch_activites)->count();
            if ($batch_count < $patient_task->quantity){
                array_push($task_list, $patient_task);
            }
        }
        
        return response()->json([
            'tasks' => $patient_tasks,
            'message' => 'Task listed successfully',
            'patient_tasks' => $task_list,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'start_date' => 'required|date',
            'task_id' => 'required|numeric',
            'repeating' => 'required|numeric|nullable',
            'frequency_id' => 'sometimes|numeric|nullable',
            'quantity' => 'sometimes|numeric|nullable',
            'domiciliary' => 'sometimes|numeric|nullable',
        ]);

        $patient_task = PatientTask::find($id);
        
        
        $patient_task->patient_id = $request->input('patient_id'); 
        $patient_task->task_id = $request->input('task_id'); 
        $patient_task->domiciliary = $request->input('domiciliary'); 
        $patient_task->details = $request->input('details'); 
        $patient_task->start_date = $request->input('start_date'); 
        $patient_task->end_date = $request->input('end_date'); 
        $patient_task->updated_by = auth('api')->id(); 
        $patient_task->frequency_id = $request->input('frequency_id');
        $patient_task->quantity = $request->input('quantity');
        $patient_task->repeating = $request->input('repeating');

        $patient_task->save();

        return response()->json([
            'patient' => Patient::where('id', '=', $patient_task->patient_id)->first(),
            'message' => 'Task created successfully',
        ]);
        
    }

    public function destroy($id)
    {
        //
    }
}
