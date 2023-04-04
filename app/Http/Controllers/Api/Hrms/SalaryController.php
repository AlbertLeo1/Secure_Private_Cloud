<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HRMS\Employee;
use App\Models\HRMS\Salary;
use App\Models\HRMS\Bonus;
use App\Models\HRMS\Deduction;
use App\Models\HRMS\Attendance;
use App\Models\HRMS\MonthSalary;

class SalaryController extends Controller
{
    public function initials()
    {
        $employee = Employee::where('user_id', '=', auth('api')->id())->with('user')->first();
        $payslips = MonthSalary::where('employee_id', '=', $employee->id)->latest()->paginate(8);

        return response()->json(['employee'=>$employee, 'payslips' => $payslips]);
    }

    public function index()
    {
        $month = \Request::get('month');
        echo $month;
        $quest = Employee::whereDate('joined_date', '<=', $month.'-01')->orWhereNull('joined_date')
        ->leftJoin('bonuses', function($join){
            $join->on('hrms_bonuses.employee_id', '=', 'hrms_employee.id');
            $join->on('hrms_bonuses.month', '=', $month);
        });
        //            ->with(['bonuses',  function ($query) {$query->where('month_id', '=', $month);}]);
        /*if ($search = \Request::get('search')){
            $quest = Employee::orderBy('unique_id', 'ASC')->with(['area','state'])->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
                });
            }
        else{
            $quest = Employee::orderBy('unique_id', 'ASC');
        }*/

        $employees = $quest->orderBy('unique_id', 'ASC')->with(['user', 'gross_salary'])->paginate(52);
        
        //Employee::where('status', 1)->with(['branch'])->get();
        return response()->json(['employees' => $employees]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $payslip = MonthSalary::where('id', '=', $id)->with('employee')->first();



        $employee = Employee::where('id', '=',  $payslip->employee_id)->with(['user', 'designation', 'department'])->first();
        $bonuses = Bonus::where('employee_id', '=', $payslip->employee_id)->where('month', '=', $payslip->month)->get();
        $deductions = Deduction::where('employee_id', '=', $payslip->employee_id)->where('month', '=', $payslip->month)->get();

        return response()->json([
            'bonuses'=> $bonuses,
            'deductions'=>$deductions,
            'employee'=>$employee, 
            'payslip' => $payslip,
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
