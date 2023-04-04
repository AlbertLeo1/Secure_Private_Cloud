<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Category;
use App\Models\Department;
use App\Models\Policy\Policy;
use App\Models\Policy\PolicyCategory;
use App\Models\Policy\PolicyDepartment;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = Policy::orderBy('name', 'ASC')->with(['depts.department', 'creator'])->paginate(25);

        return response()->json([
            'policies'      => $policies,       
            'departments'   => Department::all(),       
        ]);
    }

    public function store(Request $request)
    {
        $upload_path = "upload/policies";
        if((is_null($request->file)) || ($request->file == "")){$file_type = null; $fileName = null;}
        else{
            $fileName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path($upload_path), $fileName);
        }
        if ($request->input('id') == null){
            $data = json_decode($request->input('data'));
            print_r($data);
            $policy = Policy::create([
                'name' =>  $data->name,
                'file' => $request->file !== null ? '/'.$upload_path.'/'.$fileName : NULL,
                'category_id' => $data->category_id,
                'description' => $data->description,
                'created_by' =>  auth('api')->id(),
                'updated_by' =>  auth('api')->id(),
            ]);
        }
        else{
            //Get what was sent back
            $data = json_decode($request->input('data'));
            
            $policy = Policy::find($data->id);
            $current_file = $policy->file; //Get current file location

            //Update the Policy with new details
            $policy->name = $data->name;
            $policy->file = $request->file !== null ? '/'.$upload_path.'/'.$generated_new_name : $current_file;
            $policy->category_id = $data->category_id;
            $policy->description = $data->description;
            $policy->updated_by =  auth('api')->id();
        }


        $policies = Policy::orderBy('name', 'ASC')->with(['depts.department', 'creator'])->paginate(25);

        return response()->json([
            'policies'      => $policies,       
            'categories'    => Category::all(),       
            'departments'   => Department::all(),       
        ]);
         
    }

    public function assign(Request $request)
    {
        foreach ($request->input('departments') as $department){
            $policy_department = PolicyDepartment::where('policy_id', '=', $request->input('policy_id'))->where('department_id', '=', $department)->first();

            if ($policy_department === null){
                $policy_dept = PolicyDepartment::create([
                    'policy_id'     => $request->input('policy_id'),
                    'department_id' => $department,
                    'created_by'    => auth('api')->id(),
                ]);
            }
        }

        $policy_departments = PolicyDepartment::where('policy_id', '=', $request->input('policy_id'))->get();
        foreach ($policy_departments as $pol_dept){
            if (!in_array($pol_dept->department_id, $request->input('departments'))){
                $q = 'DELETE FROM policy_departments where `policy_id` = '.$pol_dept->policy_id.' AND `department_id` = '.$pol_dept->department_id;
                //echo $q;
                \DB::delete($q);
                //$pol_dept->delete();
            }
        }

        $policy     = Policy::find($request->input('policy_id'));
        $policies   = Policy::orderBy('name', 'ASC')->with('depts.department')->with('category')->with('creator')->paginate(25);

        return response()->json([
            'policies'      => $policies,       
            'policy'        => $policy,       
            'categories'    => Category::all(),       
            'departments'   => Department::all(),       
        ]);
         
    }

    public function all($id)
    {
        if ($id=='departmental'){
            $policies = PolicyDepartment::where('department_id', '=', auth('api')->user()->department_id)->with('policy')->with('department')->with('creator')->paginate(25);
        }
        else if ($id=='general'){
            $policies = Policy::where('category_id', '=', 0)->paginate(25);
        }

        return response()->json([
            'view'          => $id,
            'policies'      => $policies,       
            'categories'    => Category::all(),       
            'departments'   => Department::all(),       
        ]);
    }

    public function search()
    {
        if ($search = \Request::get('q')){
            $policies = Policy::orderBy('name', 'ASC')->with('category')->with('state')->with('branch')->with('department')->where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%");
                })->paginate(52);
            }
        else{
            $policies = Policy::orderBy('name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(52);
        }        
        return response()->json(['policies' => $policies,]);
    }

    public function show($id){
        $policy = Policy::find($id);

        return response()->json(['policy' => $policy,]);
    }

    public function update(Request $request, $id)
    {
        print_r($request->input());
        
        $policy = Policy::find($id);

        $current_file = $policy->file;
        
        if ($request->file != null){
            $file_name = $request->file->getClientOriginalName();
            $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move($upload_path, $generated_new_name);
        }

        $pdf = array('pdf');
        
        $policy->name = $request->input('data.name');
        $policy->file = $request->file !== null ? '/'.$upload_path.'/'.$generated_new_name : $current_file;
        $policy->category_id = $request->input('data.category_id');
        $policy->description = $request->input('data.description');
        $policy->updated_by =  auth('api')->id();

        $policy->save();

        return response()->json([
            'success' => 'You have successfully updated "' . $policy->name . '"',
            'file' => $upload_path.'/'.$generated_new_name,
            'file_type' => $file_type
            ]);
    }

    public function destroy($id)
    {
        $policy = Policy::find($id);
        
        $policy->deleted_by = auth('api')->id();
        $policy->deleted_at = date('Y-m-d H:i:s');
        $policy->save();

        //$policy->delete();

        $policies = Policy::orderBy('name', 'ASC')->with(['depts', 'creator'])->paginate(25);

        return response()->json([
            'policies'      => $policies,       
            'categories'    => Category::all(),       
            'departments'   => Department::all(),       
        ]);
    }
}
