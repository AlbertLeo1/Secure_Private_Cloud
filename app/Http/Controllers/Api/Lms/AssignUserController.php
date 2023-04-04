<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\User;

use App\Models\Lms\Course;
use App\Models\Lms\UserCourse;
use App\Models\Lms\UserExam;
use Spatie\Permission\Models\Role;

class AssignUserController extends Controller
{
    public function index()
    {
        $departments = Department::with('users')->get();
        $users = User::all();

        return response()->json(['departments' => $departments, 'users' => $users,]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ref_type'      => 'required',
            'course_id'     => 'required', 
            'start_date'    => 'required', 
            'end_date'      => 'required', 
                  'user_id.*'     => 'required|numeric', 
        ]);
        
        if ($request->input('ref_type') == "assign_user"){
            if (in_array(-1, $request->input('user_id'))){
                if ($request->input('department_id') == 1000){$users = User::all(); echo count($users);} 
                else{$users = User::where('department_id', '=', $request->input('department_id'))->get();echo count($users);}
                foreach ($users as $user){
                    UserCourse::create(
                        ['user_id' => $user->id, 'course_id' => $request->input('course_id'), 'status'=> 1, 'assigned_date' => date('Y-m-d H:i:s'), 'start_date' => $request->input('start_date'),  'expiry_date' => $request->input('end_date'), ]
                    );
                }
            }
            else{
                foreach ($request->input('user_id') as $user){
                    UserCourse::create(
                        ['user_id' => $user, 'course_id' => $request->input('course_id'), 'status'=> 1,'assigned_date' => date('Y-m-d'), 'start_date' => $request->input('start_date'),  'expiry_date' => $request->input('end_date'), ]
                    );
                } 
            }
        }
        else if($request->input('type') == "u_exam"){

        } 
        
        return response()->json([
            'assignees' => UserCourse::where('course_id', '=', $request->input('course_id'))->with('user')->get(),
            'course' => Course::where('id', '=', $request->input('course_id'))->with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons')->with('sub_category')->first(),
            //'message' => 'Category '.$category->name.' has been deleted',
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

    public function tutors(){
        $role = Role::select('id')->where('name', '=', 'Tutor')->with('users')->distinct()->get();
        $tutors = User::get();
        $departments = Department::with('users')->get();
        $users = User::all();

        return response()->json(['departments' => $departments, 'users' => $users, 'role' => $role]);
    }

    public function tutor_assign(Request $request){
        $departments = Department::with('users')->get();
        $users = User::all();

        return response()->json(['departments' => $departments, 'users' => $users,]);
    }
}
