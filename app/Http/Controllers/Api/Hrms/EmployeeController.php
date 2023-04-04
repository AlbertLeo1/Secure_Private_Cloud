<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Department;
use App\Models\Branch;
use App\Models\User;
use App\Models\HRMS\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json([
            'branches' => Branch::all(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->paginate(30), 
        ]);
    }

    public function store(Request $request)
    {
        //Validate the data sent
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'branch_id' => 'numeric',
            'department_id' => 'numeric',
            'nation_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'sex' => 'required|string',
            //'official_email' => 'required|string|unique:employees.official_email,'.$employee->id,
            //'personal_email' => 'required|string|unique:users,email,'.$user->id
        ]);
        //Create a new user
        $image = null;
        $user = User::create([
            'first_name' => $request->input('first_name'), 
            'middle_name' => $request->input('middle_name'), 
            'last_name' => $request->input('last_name'), 
            'name' => $request->input('first_name').' '.($request->input('middle_name') ?? ' ').' '.$request->input('last_name'), 
            'image' => $image, 
            'sex' => $request->input('sex'), 
            'street' => $request->input('street'), 
            'street2' => $request->input('street2'), 
            'city' => $request->input('city'), 
            'phone' => $request->input('phone'), 
            'alt_phone' => $request->input('alt_phone'), 
            'dob' => $request->input('dob'), 
            'joined_at' => $request->input('join_date'), 
            'email' => $request->input('personal_email'), 
            'password' => bcrypt('password'), 
        ]);
        //Assign new user role of Staff
        $unique_id = 'P'.sprintf('%06X', $user->id);

        $user->username = $unique_id;
        $user->save();
        

        //Create new employee assign the new user id
        $employee = Employee::create([
            'user_id' => $user->id, 
            'department_id' => $request->input('department_id'), 
            'branch_id' => $request->input('branch_id'), 
            'official_email' => $request->input('official_email'), 
            'street' => $request->input('street'), 
            'street2' => $request->input('street2'), 
            'city' => $request->input('city'), 
            'nationality_id' => $request->input('nationality_id'), 
            'qualification_id' => $request->input('qualification_id'), 
            'status' => 1,
        ]);

        //Create unique id for staff
        $unique_id = 'EKK-'.sprintf('%06X', $employee->id);
        $employee->unique_id = $unique_id;
        $employee->save();

        $user->username = $unique_id;
        $user->save();

        //Return json from index
        return response()->json([
            'branches' => Branch::all(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->paginate(30), 
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'branch_id' => 'numeric',
            'department_id' => 'numeric',
            'nation_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'sex' => 'required|string',
        ]);

        $employee = Employee::findorfail($id);
        $user = User::findorfail($employee->user_id);
        $image = null;
       
        $user->first_name = $request->input('first_name'); 
        $user->middle_name = $request->input('middle_name'); 
        $user->last_name = $request->input('last_name'); 
        $user->name = $request->input('first_name').' '.($request->input('middle_name') ?? ' ').' '.$request->input('last_name'); 
        $user->image = $image; 
        $user->sex = $request->input('sex'); 
        $user->street = $request->input('street'); 
        $user->street2 = $request->input('street2'); 
        $user->city = $request->input('city'); 
        $user->phone = $request->input('phone'); 
        $user->alt_phone = $request->input('alt_phone'); 
        $user->dob = $request->input('dob'); 
        $user->joined_at = $request->input('join_date'); 
        $user->email = $request->input('personal_email'); 
        $user->password = bcrypt('password'); 
        
        $employee->user_id = $user->id; 
        $employee->department_id = $request->input('department_id'); 
        $employee->branch_id = $request->input('branch_id'); 
        $employee->official_email = $request->input('official_email'); 
        $employee->street = $request->input('street'); 
        $employee->street2 = $request->input('street2'); 
        $employee->city = $request->input('city'); 
        $employee->nationality_id = $request->input('nation_id'); 
        $employee->qualification_id = $request->input('qualification_id'); 
        $employee->status = 1;

        $employee->save();
        $user->save();

        return response()->json([
            'branches' => Branch::all(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->paginate(30), 
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        $user = User::find($employee->user_id);

        //Delete User 
        //$user->status = 2;
        $user->deleted_by = auth('api')->id();
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();
        
        //Delete Employee Record
        $employee->status = 2;
        $employee->deleted_by = auth('api')->id();
        $employee->deleted_at = date('Y-m-d H:i:s');
        $employee->save();

        return response()->json([
            'branches' => Branch::all(),
            'departments' => Department::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->paginate(30), 
        ]);
    }
}
