<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BranchController extends Controller
{
    public function index()
    {
        return response()->json([
            'branches'    => Branch::with('users')->with('chief_consultant')->with('head_nurse')->with('practice_manager')->orderBy('name', 'ASC')->paginate(10),       
            'users'       => User::orderBy('first_name', 'ASC')->get(),       
        ]);        
    }

    public function store(Request $request)
    {
        Branch::create([
            'name'      =>  $request->input('name'),
            'address'   =>  $request->input('description') ?? '',
            'pm_id'     =>  $request->input('pm_id'),
            'cinc_id'   =>  $request->input('cinc_id'),
            'hon_id'    =>  $request->input('hon_id'),
        ]);

        $practice_manager = User::find($request->input('pm_id'));
        $practice_manager_role = Role::where('name', '=', 'Practice Manager')->first();
        $practice_manager->assignRole($practice_manager_role);

        $chief_consultant = User::find($request->input('cinc_id'));
        $chief_consultant_role = Role::where('name', '=', 'Chief Consultant')->first();
        $chief_consultant->assignRole($chief_consultant_role);

        $head_nurse = User::find($request->input('hon_id'));
        $head_nurse_role = Role::where('name', '=', 'Head Nurse')->first();
        $head_nurse->assignRole($head_nurse_role);

        return response()->json([
            'branches' => Branch::with('users')->with('hod')->orderBy('name', 'ASC')->paginate(10),       
            'users'       => User::orderBy('first_name', 'ASC')->get(),       
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'branch'    => Branch::where('id', '=', $id)->with('users')->with('hod')->orderBy('name', 'ASC')->first(),       
            'users'       => User::all(),       
        ]);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);

        $branch->name        = $request->input('name');
        $branch->address     = $request->input('description') ?? '';
        $branch->pm_id      = $request->input('pm_id');
        $branch->cinc_id      = $request->input('cinc_id');
        $branch->hon_id      = $request->input('hon_id');
        
        $branch->save();

        $practice_manager = User::find($request->input('pm_id'));
        $practice_manager_role = Role::where('name', '=', 'Practice Manager')->first();
        $practice_manager->assignRole($practice_manager_role);

        $chief_consultant = User::find($request->input('cinc_id'));
        $chief_consultant_role = Role::where('name', '=', 'Chief Consultant')->first();
        $chief_consultant->assignRole($chief_consultant_role);

        $head_nurse = User::find($request->input('hon_id'));
        $head_nurse_role = Role::where('name', '=', 'Head Nurse')->first();
        $head_nurse->assignRole($head_nurse_role);

        return response()->json([
            'branches' => Branch::with('users')->with('practice_manager')->with('chief_consultant')->with('head_nurse')->orderBy('name', 'ASC')->paginate(10),       
            'users'       => User::orderBy('first_name', 'ASC')->get(),       
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