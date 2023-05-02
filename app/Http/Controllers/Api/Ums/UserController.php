<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Department;
use App\Models\NextOfKin;
use App\Models\Staff;
use App\Models\State;
use App\Models\User;

use App\Models\EMR\Patient;
use App\Models\HRMS\Employee;
use Spatie\Permission\Models\Role;

use App\Models\LogActivity;

class UserController extends Controller
{
    public function initials()
    {
        $users = User::orderBy('first_name', 'ASC')->with(['state', 'area'])->paginate(52);
        //$states = State::with('areas')->orderBy('name', 'ASC')->get();
        //$areas = Area::where('state_id', '=', 25)->orderBy('name', 'ASC')->get();
        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled all users', 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'areas' => Area::where('state_id', '=', 25)->orderBy('name', 'ASC')->get(),
            'states' => State::with('areas')->orderBy('name', 'ASC')->get(),
            'users' => $users,
        ]);
    }
      
    public function index()
    {
        $areas  = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $nok    = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users  = User::orderBy('first_name', 'ASC')->with(['area','state'])->with('roles')->paginate(51);
        
        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled all users', 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'areas'     => $areas,
            'nok'       => $nok,
            'states'    => $states,       
            'users'     => $users,
        ]);
    }

    public function roles(Request $request){
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'roles' => 'required|array',
        ]);

        $user = User::find($request->input('user_id'));
        $roles = Role::whereIn('id', $request->input('roles'))->get();
        $role_names = [];
        foreach ($roles as $role){
            array_push($role_names, $role->name);
            $user->removeRole($role->name);
        }
        $user->syncRoles($role_names);
        
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users = User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('roles')->paginate(51);

        return response()->json([
            'areas' => $areas,
            'nok' => $nok,
            'states' => $states,       
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            //'branch_id' => 'required|numeric',
            'sex' => 'required|string',
            'dob' => 'required|date',
            //'unique_id' => 'required|unique:users',
        ]);

        $image_url = null;
        if (!is_null($request['image'])){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/profile/').$image);
            $image_url = $image;
        }
        
        $user = User::create([
            'email' => $request['email'],
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'last_name' => $request['last_name'],
            'street' => $request['street'],
            'street2' => $request['street2'],
            'city' => $request['city'],
            'state_id' => $request['state_id'],
            'area_id' => $request['area_id'],
            //'personal_email' => $request['personal_email'],
            //'phone' => $request['phone'],
            //'alt_phone' => $request['alt_phone'],
            'sex' => $request['sex'],
            'dob' => $request['dob'],
            'image' => $image_url,
            'updated_at' => date('Y-m-d H:i:s'),
            'joined_at' => $request['joined_at'],
            'username' => $request['unique_id'],
            ]);

        $user->save();

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' created a new user with id'.$user->id, 
            'url' => 'This is a test', 
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            // This are the required for User page
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(51),

            //This is the based on the service requested
            'message' => 'Your password has been changed successfully',
            'status' => 'success', 
            'user' => $user,
        ]);
    }
    
    public function search()
    {
        if ($search = \Request::get('q')){
            $users = User::orderBy('first_name', 'ASC')->with(['area','state'])->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
                })->paginate(52);
            }
        else{
            $search = '';
            $users = User::orderBy('first_name', 'ASC')->with(['area', 'state'])->paginate(52);
        }
        
        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' searched users for '.$search, 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json(['users' => $users,]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        
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

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' changed his password', 
            'url' => 'This is a test', 
            'method' => 'update', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Your password has been changed successfully']);
        
    }
    
    public function profile()
    {
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->first();
        $states = State::orderBy('name', 'ASC')->get();
        $user = User::where('id', auth('api')->id())->with('area')->with('state')->first();
        //$nations = Country::orderBy('name', 'ASC')->get();

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled his profile', 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            //'nations' => Country::orderBy('name', 'ASC')->get(),
            'areas' => $areas,
            'user' => $user,
            'nok' => $nok,
            'states' => $states,
            //'nations' => $nations,
            //'patient' => Patient::where('user_id',  auth('api')->id())->first(),       
        ]);
    }
    
    public function show($id)
    {
        $areas  = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users = [];
        if (is_string($id)){
            $users = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-14 days')))->latest()->with(['area','state','roles'])->paginate(51);
        }

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pulled profile of user with id: '.$id, 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'areas'     => $areas,
            'states'    => $states,       
            'users'     => $users,
        ]);
    }


    public function details(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'nationality_id' => 'required',
            'passport_no' => 'required',
        ]);

        $patient = Patient::find($request->input('user_id'));

        $patient->nationality_id = $request->input('nationality_id');
        $patient->passport_no = $request->input('passport_no');

        $patient->save();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'branch_id' => 'required|numeric',
            'sex' => 'required|string',
            'dob' => 'required|date',
        ]);

        $user = User::find($id);
        $image_url = $currentPhoto = $user->image;
         
        if (($request['image'] != $currentPhoto) && ($request['image'] != '')){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/profile/').$image);
            $image_url = $image;
            $old_image = public_path('img/profile/').$currentPhoto;

            if (file_exists($old_image)){ @unlink($old_image); }
        }

        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->middle_name = $request['middle_name'];
        $user->last_name = $request['last_name'];
        $user->street = $request['street'];
        $user->street2 = $request['street2'];
        $user->city = $request['city'];
        $user->state_id = $request['state_id'];
        $user->area_id = $request['area_id'];
        //$user->personal_email = $request['personal_email'];
        $user->phone = $request['phone'];
        //$user->alt_phone = $request['alt_phone'];
        $user->branch_id = $request['branch_id'];
        $user->department_id = $request['department_id'];
        $user->sex = $request['sex'];
        $user->dob = $request['dob'];
        $user->image = $image_url;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->joined_at = $request->input('joined_at');
        $user->dob = $request->input('dob');
        $user->username = $request->input('unique_id');
            
        $user->save();

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' updated user with id: '.$id, 
            'url' => 'This is a test', 
            'method' => 'update', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            // This are the required for User page
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(51),

            //This is the based on the service requested
            'message' => 'Your password has been changed successfully',
            'status' => 'success', 
            'user' => $user,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' deleted user with id: '.$id, 
            'url' => 'This is a test', 
            'method' => 'delete', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);
        return response()->json([
            // This are the required for User page
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(51),

            //This is the based on the service requested
            'message' => 'The user '.$user->first_name.' '.$user->last_name.' has been deleted',
            'status' => 'success', 
            'user' => $user,
        ]);
    }
}
