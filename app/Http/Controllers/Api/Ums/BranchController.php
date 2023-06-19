<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Inventory\Device;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BranchController extends Controller
{
    public function index()
    {
        return response()->json([
            'branches'    => Branch::orderBy('name', 'ASC')->paginate(10),        
        ]);        
    }

    public function store(Request $request)
    {
        Branch::create([
            'name'      => $request->input('name'),
            'address'   => $request->input('address') ?? '',
            'unique_id' => 'C',
            'current'   => 0,
            'pm_id'     => $request->input('pm_id') ?? NULL,
            'cinc_id'   => $request->input('cinc_id') ?? NULL,
            'hon_id'    => $request->input('hon_id') ?? NULL,
        ]);

        return response()->json([
            'branches' => Branch::orderBy('name', 'ASC')->paginate(10),       
    
        ]);
    }

    public function show($id)
    {
        $previous_week = strtotime("-1 week +1 day");
        $old_begins = date("Y-m-d H:i:s", $previous_week);

        return response()->json([
            'all_devices'       => Device::where('branch_id', '=', $id)->whereNotIn('status', ['Sold', 'Discontinued'])->count(),
            'new_devices'       => Device::where('branch_id', '=', $id)->whereDate('created_at', '>=', $old_begins)->count(),
            'damaged_devices'   => Device::where('branch_id', '=', $id)->where('status', '=','Damaged')->count(),
            'repaired_devices'  => Device::where('branch_id', '=', $id)->where('status', '=', 'Repaired')->count(),
            'sold_devices'      => Device::where('branch_id', '=', $id)->where('status', '=', 'Sold')->count(),
            'due_devices'       => Device::where('branch_id', '=', $id)->where('status', '=', 'Due')->count(),
            //'all_devices' => Device::with('branch')->count(),  
            'branch'    => Branch::where('id', '=', $id)->orderBy('name', 'ASC')->first(),

        ]);
    }

    public function update(Request $request, $id)
    {
        
        $branch = Branch::find($id);

        $branch->name        = $request->input('name');
        $branch->address     = $request->input('address') ?? '';
        
        $branch->save();

        return response()->json([
            'branches' => Branch::with('users')->orderBy('name', 'ASC')->paginate(10),       
        ]);
    }

    public function destroy($id)
    {
        $users = User::where('branch_id', '=', $id)->get();
        if ((count($users) != 0) && (!is_null($users))){
            foreach ($users as $user){
                $user->branch_id = null;
                $user->save();
            }
        }
        
        $branch = Branch::find($id);
        $branch->deleted_by = auth('api')->id();
        $branch->deleted_at = date('Y-m-d H:i:s');
        $branch->save();

        return response()->json([
            'branches' => Branch::with('users')->with('practice_manager')->with('chief_consultant')->with('head_nurse')->orderBy('name', 'ASC')->paginate(10),       
            'users'       => User::orderBy('first_name', 'ASC')->get(),       
        ]); 
    }
}