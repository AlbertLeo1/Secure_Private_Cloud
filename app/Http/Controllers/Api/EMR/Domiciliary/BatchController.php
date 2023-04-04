<?php

namespace App\Http\Controllers\Api\EMR\Domiciliary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Domiciliary;
use App\Models\EMR\Batch;
use App\Models\EMR\BatchActivity;
use App\Models\EMR\BatchAssign;
use App\Models\EMR\ShiftType;
use App\Models\EMR\Patient;
use App\Models\EMR\PatientTask;

use App\Models\HRMS\EmployeeType;


class BatchController extends Controller
{
    public function index()
    {
        $active_request = Domiciliary::select('patient_id')
        ->where('active', '=', 1)
        ->whereDate('start_date', '<=', date('Y-m-d'))
        ->whereDate('end_date', '>=', date('Y-m-d'))
        ->orWhereNull('end_date')
        ->get();
        
        return response()->json([
            'active' => $active_request,
            'batches' => Batch::orderBy('start_date', 'DESC')->with(['patient.tasks.task', 'staff_type', 'shift_type', 'activities.task_details'])->paginate(20),
            'patients' => Patient::whereIn('id', $active_request)->orderBy('first_name')->get(), 
            'shift_types' => ShiftType::orderBy('name', 'ASC')->get(),
            'staff_types' => EmployeeType::orderBy('name', 'ASC')->get(),   
        ]);
    }

    public function store(Request $request)
    {
        $batch = Batch::create([
            'patient_id' => $request->input('patient_id'), 
            'shift_type_id'  => $request->input('shift_type_id'),
            'staff_type_id'  => $request->input('staff_type_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date') ?? NULL,
            'status' => 1, 
            'created_by' => auth('api')->id(), 
            'updated_by' => auth('api')->id(),
        ]);

        foreach ($request->input('tasks') as $task){
            BatchActivity::create([
                'patient_task_id' => $task,
                'batch_id' => $batch->id,
            ]);
        }

        $active_request = Domiciliary::select('patient_id')->whereDate('end_date', '<=', date('Y-m-d'))->orWhereNull('end_date')->where('active', '=', 1)->get();
        
        return response()->json([
            'batches' => Batch::orderBy('start_date', 'DESC')->where('status', '<=', 1)->get(),
            'patients' => Patient::whereIn('id', $active_request)->orderBy('first_name')->get(), 
            'shift_types' => ShiftType::orderBy('name', 'ASC')->get(),
            'staff_types' => EmployeeType::orderBy('name', 'ASC')->get(),   
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $batch->patient_id = $request->input('patient_id'); 
        $batch->shift_type_id = $request->input('shift_type_id');
        $batch->staff_type_id = $request->input('staff_type_id');
        $batch->start_date = $request->input('start_date');
        $batch->end_date = $request->input('end_date') ?? NULL;
        $batch->status = 1; 
        $batch->created_by = auth('api')->id(); 
        $batch->updated_by = auth('api')->id();
        
        $batch->save();

        BatchActivity::where('batch_id', '=', $batch->id)->delete();

        foreach ($request->input('tasks') as $task){
            BatchActivity::create([
                'patient_task_id' => $task,
                'batch_id' => $batch->id,
            ]);
        }

        $active_request = Domiciliary::select('patient_id')->whereDate('end_date', '<=', date('Y-m-d'))->orWhereNull('end_date')->where('active', '=', 1)->get();
        
        return response()->json([
            'batches' => Batch::orderBy('start_date', 'DESC')->where('status', '<=', 1)->get(),
            'patients' => Patient::whereIn('id', $active_request)->orderBy('first_name')->get(), 
            'shift_types' => ShiftType::orderBy('name', 'ASC')->get(),
            'staff_types' => EmployeeType::orderBy('name', 'ASC')->get(),   
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
