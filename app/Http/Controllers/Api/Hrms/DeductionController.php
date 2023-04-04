<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HRMS\Employee;
use App\Models\HRMS\Deduction;
use App\Models\HRMS\RecurringDeduction;
class DeductionController extends Controller
{
    public function index()
    {
        $month = \Request::get('month');
        
        $deductions = Deduction::where('month', '=', $month)->with(['employee.user'])->paginate(50);
        $employees = Employee::orderBy('unique_id', 'ASC')->with(['user'])->get();    
        
        return response()->json([
            'deductions' => $deductions,
            'employees' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'employee_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'month' => 'required',
            'description' => 'string|nullable',
        ]);

        if ($request->input('type') == 'recurring'){
            $recurring_deduction = RecurringDeduction::create([
                'name' => $request->input('name'),
                'employee_id' => $request->input('employee_id'),
                'amount' => $request->input('amount'),
                'description' => $request->input('description'),
                'start_date' => $request->input('start_date'),
                'end_date'  => $request->input('end_date'),
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);
        }

        else{
            $deduction = Deduction::create([
                'name' => $request->input('name'),
                'employee_id' => $request->input('employee_id'),
                'amount' => $request->input('amount'),
                'month' => $request->input('month'),
                'description' => $request->input('description'),
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);
        }

        $deductions = Deduction::where('month', '=', $request->input('month'))->with(['employee.user'])->paginate(50);
        $employees = Employee::orderBy('unique_id', 'ASC')->with(['user'])->get();    
        
        return response()->json([
            'deductions' => $deductions,
            'employees' => $employees,
        ]);
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
