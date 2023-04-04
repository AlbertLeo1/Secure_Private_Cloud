<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Branch;
use App\Models\NextOfKin;
use App\Models\State;
use App\Models\User;
use App\Models\Staff;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permissions;
use App\Models\HRMS\Employee;

class UserController extends Controller
{
    public function contacts()
    {
        $users = Employee::orderBy('unique_id', 'ASC')->with(['department', 'designation', 'user'])->paginate(52);
        
        return response()->json(['users' => $users]);
    }

    public function initials()
    {
        $users = User::where('branch_id', auth('api')->user()->branch_id)->paginate(50);
        return response()->json(['users' => $users]);
    }
    
    
    public function index()
    {
        $users = User::where('branch_id', auth('api')->user()->branch_id)->with('state')->with('branch')->orderBy('branch_id')->get();
        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        //
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        /*
        $user->first_name = $request->input('first_name'); 
        $user->middle_name = $request->input('other_name'); 
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email'); 
        $user->unique_id = $request->input('unique_id');
        $user->street = $request->input('street');
        $user->street2 = $request->input('street2'); 
        $user->city = $request->input('city');
        $user->sex = $request->input('sex');
        $user->state_id = $request->input('state_id'); 
        $user->phone = $request->input('phone');
        $user->branch_id = $request->input('branch_id');

        $user->save();      
        */
        if ($request->input('image')){
            $name = time().'.'.explode('/',explode(':', substr($request->input('image'), 0, strpos($request->input('image'), ';'))))[1][1];
        }
        return response()->json(['status' => 'Successful']);
    }

    public function password(Request $request)
    {
        $this->validate($request, [
            'npw' => 'required|min:8|required_with:cpw|same:cpw',
            'opw' => 'required',
            'cpw' => 'required|min:8',
        ]);

        $user = User::find(auth('api')->id());
        
        $user->password = bcrypt($request->npw);
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Your password has been changed successfully']);
        
    }
    
    public function passwordReset(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8|required_with:password_confirm|same:password_confirm',
            'user_id' => 'required|numeric',
            'password_confirm' => 'required|min:8',
        ]);

        $user = User::find($request->input('user_id'));
        
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Your password has been changed successfully']);
        
    }
    
    public function profile()
    {
        $branches = Branch::all();
        $user = Staff::where('user_id', auth('api')->id())->with('area')->with('state')->with('branch')->first();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $areas = Area::where('state_id', 25)->orderBy('name', 'ASC')->get();
        return response()->json([
            'areas' => $areas,
            'user' => $user,
            'branches' => $branches,
            'nok' => $nok,
            'states' => $states,       
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
