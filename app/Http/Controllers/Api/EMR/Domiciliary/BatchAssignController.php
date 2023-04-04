<?php

namespace App\Http\Controllers\Api\EMR\Domiciliary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\EMR\Batch;
use App\Models\EMR\BatchAssign;
use App\Models\EMR\BatchActivity;
use App\Models\EMR\Patient;
use App\Models\HRMS\Employee;

class BatchAssignController extends Controller
{
    public function assigned()
    {
        $staff = Employee::where('user_id', '=', auth('api')->id())->first();
        $batches = BatchAssign::where('staff_id', '=', $staff->id)->where('date', '=', date('Y-m-d'))->with('patient', 'shift_type', 'staff_type')->paginate(20);
        
        return response()->json([
            'daily_batches' => $batches,
        ]);
    }


    public function confirmArrival(Request $request, $id)
    {
        $daily_batch = BatchAssign::where('id', '=', $id)->first();

        $daily_batch->arrived_at = date('Y-m-d H:i:s');
        $daily_batch->arrival_channel = "Web App";
        $daily_batch->status = 1;

        $daily_batch->save();

        $batch_assign = BatchAssign::findOrFail($id);
        $tasks = BatchActivity::where('batch_id', '=', $batch_assign->batch->id)->with('task_details')->get();
        
        return response()->json([
            'tasks' => $tasks,
            'message' => 'Working',
            'shift'   => $batch_assign,
            'patient' => Patient::find($batch_assign->batch->patient_id),
        ]);
    }


    public function index()
    {
        $date = date('Y-m-d');
        $quest = "`emr_batches`.`id` as batched_id, `emr_batches`.`patient_id`, `emr_batches`.`shift_type_id`, `emr_batches`.`staff_type_id`, `emr_batch_daily_assignments`.*, `users`.`first_name`, `users`.`middle_name`,`users`.`last_name`, `hrms_employees`.`unique_id`,`hrms_employees`.`user_id`";

        $batch_query = Batch::select(DB::raw('"'.$date.'" as raw_date,'.$quest))
        ->whereDate('end_date', '<=', $date)->orWhereNull('end_date')
            ->orWhereDate('start_date', '>=', $date)
            ->leftJoin('emr_batch_daily_assignments', function ($join) use ($date) {
                $join->on('emr_batches.id', '=', 'emr_batch_daily_assignments.batch_id')
                    ->whereDate('emr_batch_daily_assignments.date', '=', $date);
            })
            ->leftJoin('hrms_employees', 'emr_batch_daily_assignments.staff_id', '=', 'hrms_employees.id')
            ->leftJoin('users', 'hrms_employees.user_id', '=', 'users.id');

        $daily_batches = $batch_query->orderBy('raw_date', 'ASC')->with(['shift_type', 'staff_type', 'patient'])->paginate(50);
        
        return response()->json([
            'daily_batches' => $daily_batches,
            'staffs' => Employee::where('status', '=', 1)->with(['qualification', 'user'])->get(),
        ]);
    }

    public function search(Request $request)
    {
        //Validations
        $this->validate($request, [
            //'patient' => 'sometimes|nullable',
            'end_date' => 'sometimes|date|nullable',
            'start_date' => 'sometimes|date|nullable',
        ]);

        //Declarations and Initializations
        $start = new \DateTime($request->input('start_date'));
        $begin = new \DateTime($request->input('start_date'));
        $ending = (empty($request->input('end_date')) || is_null($request->input('end_date')) || $request->input('end_date') == "") ? $begin->modify('+7 days') : new \DateTime($request->input('end_date'));
        //$users = [];

        /*if ($search = $request->input('patient')){
            $users = Patient::select('id')->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
                }
            )->get();
        }*/

        $quest = "`emr_batches`.`id` as batched_id, `emr_batches`.`patient_id`, `emr_batches`.`shift_type_id`, `emr_batches`.`staff_type_id`, `emr_batch_daily_assignments`.*, `users`.`first_name`, `users`.`middle_name`,`users`.`last_name`, `hrms_employees`.`unique_id`,`hrms_employees`.`user_id`";
        $batch_query = Batch::select(DB::raw('"'.$ending->format("Y-m-d").'" as raw_date,'.$quest))
        ->whereDate('end_date', '<=', $ending->format("Y-m-d"))->orWhereNull('end_date')
            ->orWhereDate('start_date', '>=', $ending->format("Y-m-d"))
            ->leftJoin('emr_batch_daily_assignments', function ($join) use ($ending) {
                $join->on('emr_batches.id', '=', 'emr_batch_daily_assignments.batch_id')
                    ->whereDate('emr_batch_daily_assignments.date', '=', $ending->format("Y-m-d"));
            })
            ->leftJoin('hrms_employees', 'emr_batch_daily_assignments.staff_id', '=', 'hrms_employees.id')
            ->leftJoin('users', 'hrms_employees.user_id', '=', 'users.id');
            
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $ending);
        foreach ($period as $dt) {
            $query = Batch::select(DB::raw('"'.$dt->format("Y-m-d").'" as raw_date, '.$quest))
            ->whereDate('end_date', '<=', $dt->format("Y-m-d"))->orWhereNull('end_date')
            ->orWhereDate('start_date', '>=', $dt->format("Y-m-d"))
            ->leftJoin('emr_batch_daily_assignments', function ($join) use ($dt){
                $join->on('emr_batches.id', '=', 'emr_batch_daily_assignments.batch_id')
                    ->whereDate('emr_batch_daily_assignments.date', '=', $dt->format("Y-m-d"));
            })
            ->leftJoin('hrms_employees', 'emr_batch_daily_assignments.staff_id', '=', 'hrms_employees.id')
            ->leftJoin('users', 'hrms_employees.user_id', '=', 'users.id');
            
            $batch_query = $batch_query->union($query);

            //echo ($count++);
        }
        
        $daily_batches = $batch_query->orderBy('raw_date', 'ASC')->with(['shift_type', 'staff_type', 'patient'])->paginate(50);

        return response()->json([
            'daily_batches' => $daily_batches,
            'staffs' => Employee::where('status', '=', 1)->with(['qualification', 'user'])->get(),
        ]);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'batch_id'  => 'required|numeric',
            'date'      => 'required|date',
            'staff_id'  => 'required|numeric',
        ]);

        $batch_assign = BatchAssign::create([
            'batch_id' => $request->input('batch_id'),
            'date'  => $request->input('date'),
            'staff_id' => $request->input('staff_id'),
            'status' => 0,
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'message' => 'Shift Assigned Successfully',
        ]);
    }

    public function show($id)
    {
        $batch_assign = BatchAssign::findOrFail($id);
        $tasks = BatchActivity::where('batch_id', '=', $batch_assign->batch->id)->with('task_details')->get();
        
        return response()->json([
            'tasks' => $tasks,
            'message' => 'Working',
            'shift'   => $batch_assign,
            'patient' => Patient::find($batch_assign->batch->patient_id),
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
