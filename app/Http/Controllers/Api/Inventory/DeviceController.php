<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\Device;
use App\Models\Branch;
use App\Models\Department;
use App\Models\State;
use App\Models\User;

class DeviceController extends Controller
{
    public function index()
    {
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
