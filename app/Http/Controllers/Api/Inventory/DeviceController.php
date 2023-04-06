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
            'devices' => Device::with('branch', 'user')->paginate(30),  
            'states' => State::select('id', 'name')->orderBy('name', 'ASC')->with('areas')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::orderBy('last_name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $device = Device::create([

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
