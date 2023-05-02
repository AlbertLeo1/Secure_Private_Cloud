<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\Device;
use App\Models\Branch;
use App\Models\Department;
use App\Models\State;
use App\Models\User;

use App\Models\LogActivity;

class DeviceController extends Controller
{
    public function index()
    {
        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled all devices', 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'devices' => Device::with('branch')->paginate(30),  
            'states' => State::select('id', 'name')->orderBy('name', 'ASC')->with('areas')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::orderBy('last_name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $device = Device::create([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'serial_number' => $request->input('serial_number'),
            'unique_code' => $request->input('unique_code'),
            'model' => $request->input('model'),
            'branch_id' => $request->input('branch_id'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'mac_address' => $request->input('mac_address'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' successfully created device with id:'.$device->id, 
            'url' => 'This is a test', 
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'devices' => Device::with('branch')->paginate(30),  
            'states' => State::select('id', 'name')->orderBy('name', 'ASC')->with('areas')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::orderBy('last_name', 'ASC')->get(),
        ]);
    }

    public function show($id)
    {
        
    }

    public function status()
    {
        if ($search = \Request::get('status')){
            $log_activity = LogActivity::create([
                'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled all '.$search.' devices', 
                'url' => 'This is a test', 
                'method' => 'read', 
                'ip' => \Illuminate\Support\Facades\Request::ip(), 
                'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                'user_id' => auth('api')->id(),
            ]);

            if ($search == 'new'){
                $previous_week = strtotime("-1 week +1 day");
                $old_begins = date("Y-m-d H:i:s", $previous_week);
                $devices = Device::whereDate('created_at', '>=', $old_begins)->with('branch')->paginate(30);
            }
            else {$devices = Device::where('status', '=', $search)->with('branch')->paginate(30);}  

            }
        else{
            $log_activity = LogActivity::create([
                'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled unknown device status on devices', 
                'url' => 'This is a test', 
                'method' => 'read', 
                'ip' => \Illuminate\Support\Facades\Request::ip(), 
                'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                'user_id' => auth('api')->id(),
            ]);
            
            $devices = NULL;
        }

        return response()->json([
            'branches'      => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'devices'       => $devices,  
            'states'        => State::select('id', 'name')->orderBy('name', 'ASC')->with('areas')->get(),
            'departments'   => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users'         => User::orderBy('last_name', 'ASC')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->name = $request->input('name');
        $device->brand = $request->input('brand');
        $device->serial_number = $request->input('serial_number');
        $device->unique_code = $request->input('unique_code');
        $device->model = $request->input('model');
        $device->branch_id = $request->input('branch_id');
        $device->description = $request->input('description');
        $device->status = $request->input('status');
        $device->mac_address = $request->input('mac_address');
        $device->updated_by = auth('api')->id();
        
        $device->save();

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' successfully updated device with id:'.$id, 
            'url' => 'This is a test', 
            'method' => 'update', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'devices' => Device::with('branch')->paginate(30),  
            'states' => State::select('id', 'name')->orderBy('name', 'ASC')->with('areas')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::orderBy('last_name', 'ASC')->get(),
        ]);

    }

    public function destroy($id)
    {
        $device = Device::find($id);

        $device->deleted_by = auth('api')->id();
        $device->deleted_at = date('Y-m-d H:i:s');

        $device->save();

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' successfully deleted device with id:'.$id, 
            'url' => 'This is a test', 
            'method' => 'delete', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'message' => 'Device deleted successfully',
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'devices' => Device::with('branch', 'user')->paginate(30),  
            'states' => State::select('id', 'name')->orderBy('name', 'ASC')->with('areas')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::orderBy('last_name', 'ASC')->get(),
        ]);
    }
}
