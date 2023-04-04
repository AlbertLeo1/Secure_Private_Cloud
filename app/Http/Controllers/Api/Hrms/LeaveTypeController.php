<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HRMS\LeaveType;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leave_types = LeaveType::orderBy('name', 'ASC')->paginate(20);
        $message = 'Loaded';
        $status = 'success';


        return response()->json([
            'leave_types' => $leave_types,
            'message' => $message,
            'status' => $status,
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|unique:hrms_leave_types,name',
            'amount' => 'required',
            'status' => 'required',
        ]);

        $leave_exist = LeaveType::where('name', $request->name)->first();
        if ($leave_exist == null) {
            LeaveType::create([
                'name'   => $request->name,
                'count' => $request->amount,
                'status' => $request->status,
            ]);
            $status = 'success'; 
            $message = 'Leave type is created successfully';
        } 
        else {
            $status = 'error';
            $message = 'Leave type with this name already exist';
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required',
            'status' => 'sometimes',
        ]);

        $leave_type = LeaveType::find($id);
        $leave_type->name = $request->name;
        $leave_type->count = $request->amount;
        $leave_type->status = $request->status;
        $leave_type->save();
        //Session::flash('success', 'Leave type is updated successfully');

        return response()->json([
            'message' => 'Leave Type has been updated',
        ]);
    }

    public function destroy($id)
    {
        $leave_type = LeaveType::find($id);
        $leave_type->delete();
        //Session::flash('success', 'Leave type is deleted successfully.');

        return response()->json([
            'message' => 'Leave Type has been deactivated',
        ]);
    }
}
