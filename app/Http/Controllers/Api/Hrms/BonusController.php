<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HRMS\Bonus;
use App\Models\HRMS\Employee;



class BonusController extends Controller
{
    public function index()
    {
        $month = \Request::get('month');
        
        $bonuses = Bonus::where('month', '=', $month)->with(['employee.user'])->paginate(50);
        $employees = Employee::orderBy('unique_id', 'ASC')->with(['user'])->get();    
        
        return response()->json([
            'bonuses' => $bonuses,
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

        $bonus = Bonus::create([
            'name' => $request->input('name'),
            'employee_id' => $request->input('employee_id'),
            'amount' => $request->input('amount'),
            'month' => $request->input('month'),
            'description' => $request->input('description'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        $bonuses = Bonus::where('month', '=', $request->input('month'))->with(['employee.user'])->paginate(50);
        $employees = Employee::orderBy('unique_id', 'ASC')->with(['user'])->get();    
        
        return response()->json([
            'bonuses' => $bonuses,
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
