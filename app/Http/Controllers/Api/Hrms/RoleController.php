<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        //
        $role = Role::create(['name' => 'Deanery Admin']);
        $user = User::find(1);
        $user->assignRole($role);
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => 'Deanery Admin']);
        $user = User::find(1);
        $user->assignRole($role);

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
