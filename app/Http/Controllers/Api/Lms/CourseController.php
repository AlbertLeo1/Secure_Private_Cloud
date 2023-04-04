<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Category;
use App\Models\Lms\Course;
use App\Models\Lms\Certificate;
use App\Models\Lms\CertificateType;
use App\Models\Lms\Exam;
use App\Models\Lms\ExamType;
use App\Models\Lms\Lesson;
use App\Models\Lms\SubCategory;
use App\Models\Lms\TutorCourse;
use App\Models\Lms\UserCourse;

use App\Models\Department;
use App\Models\User;

use Spatie\Permission\Models\Role;

class CourseController extends Controller
{
    public function assign_tutors(Request $request)
    {
        $this->validate($request, [
            'course_id'         => 'required', 
            'users'             => 'required|array',
            'users.*'           => 'required|numeric|distinct',
        ]);

        foreach ($request->input('users') as $user){
            $tutor_course = TutorCourse::where('course_id', '=', $request->input('course_id'))->where('tutor_id', '=', $user)->first();

            if ($tutor_course === null){
                $tutorcourse = TutorCourse::create([
                    'course_id'     => $request->input('course_id'),
                    'tutor_id'      => $user,
                    'created_by'    => auth('api')->id(),
                    /* 'assigned_date' => date('Y-m-d H:i:s'),
                    'start_date'    => $request->input('start_date'),
                    'expiry_date'   => $request->input('expiry_date'), */
                ]);
            }
        }
        
        return response()->json([
            'categories'        => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'course'            => Course::where('id', '=', $request->input('course_id'))->with('assignees.user')->with('tutors.tutor')->with('lessons.exam')->with('category')->with('sub_category')->first(),
            'departments'       => Department::select('id', 'name')->with('users')->get(),
            'exam_types'        => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users'             => User::all(),
        ]);
    }

    public function assign_users(Request $request)
    {
        $this->validate($request, [
            'course_id'         => 'required', 
            'users'             => 'required|array',
            'users.*'           => 'required|numeric|distinct',
            //'start_date'        => 'required', 
            //'end_date'          => 'required',
        ]);

        foreach ($request->input('users') as $user){
            $user_course = UserCourse::where('course_id', '=', $request->input('course_id'))->where('user_id', '=', $user)->first();

            if ($user_course === null){
                $usercourse = UserCourse::create([
                    'course_id'     => $request->input('course_id'),
                    'user_id'       => $user,
                    'created_by'    => auth('api')->id(),
                    'assigned_date' => date('Y-m-d H:i:s'),
                    'start_date'    => $request->input('start_date'),
                    'expiry_date'   => $request->input('expiry_date'),
                ]);
            }
        }
        /*
        $user_courses = UserCourse::where('course_id', '=', $request->input('course_id'))->get();
        foreach ($user_courses as $user_course){
            if (!in_array($user_course->user_id, $request->input('users'))){
                $q = 'DELETE FROM user_courses where `course_id` = '.$user_course->course_id.' AND `user_id` = '.$user_course->user_id;
                //echo $q;
                \DB::delete($q);
                //$pol_dept->delete();
            }
        }
        */
        return response()->json([
            'categories'        => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'course'            => Course::where('id', '=', $request->input('course_id'))->with('assignees.user')->with('tutors.tutor')->with('lessons.exam')->with('category')->with('sub_category')->first(),
            'departments'       => Department::select('id', 'name')->with('users')->get(),
            'exam_types'        => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users'             => User::all(),
        ]);
    }

    public function index()
    {
        return response()->json([
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(10),  
            'departments'=> Department::select('id', 'name')->with('users')->orderBy('name', 'ASC')->get(),     
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
            'tutors' => User::role('tutor')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required', 
            'category_id'       => 'required', 
            'sub_category_id'   => 'required', 
            'description'       => 'nullable|string', 
            'price'             => 'required|numeric', 
            'exam_type_id'      => 'required|numeric', 
            'certificate_type_id' => 'required|numeric',
            'lessons'           => 'required|numeric',
        ]);

        $sub_category = SubCategory::find($request['sub_category_id']);
        //Create the Course
        $course = Course::create([
            'name' => $request['name'], 
            'category_id' => $sub_category->category_id, 
            'description' => $request['description'], 
            'sub_category_id' => $sub_category->id, 
            'price' => $request['price'], 
            'exam_type_id' => $request['exam_type_id'], 
            'certificate_type_id' => $request['certificate_type_id'], 
        ]);

        if ($request['exam_type_id'] == 4 || $request['exam_type_id'] == 5){$lesson_type_id = 1;}
        else{$lesson_type_id = 2;}
        
        for ($i = 1; $i <= $request->input('lessons'); $i++){
            $lesson = Lesson::create([
                'name' => 'Sample Module '.$i,
                'course_id' => $course->id, 
                'content' => 'Kindly edit to need', 
                'lesson_type_id' => $lesson_type_id,
                'document' => null,
                'video' => null,
                'pdf' => null,
                'serial_number' => null,
            ]);
        }
        
        return response()->json([
            'message' => 'New Course: '.$course->name.' has been created successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'course' => Course::where('id', '=', $id)->with('assignees.user')->with('tutors.tutor')->with('lessons.exam')->with('category')->with('sub_category')->first(),
            'departments' => Department::select('id', 'name')->with('users')->get(),
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'tutors' => User::role('Tutor')->get(),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required', 
            'category_id' => 'required', 
            'sub_category_id' => 'required', 
            'description' => 'required', 
            'price' => 'required|numeric', 
            'exam_type_id' => 'required|numeric', 
            'certificate_type_id' => 'required|numeric',
        ]);

        $sub_category = SubCategory::find($request['sub_category_id']);
        
        //Find the Course
        $course = Course::find($id);
                
        $course->name               = $request['name']; 
        $course->category_id        = $sub_category->category_id;
        $course->description        = $request['description']; 
        $course->sub_category_id    = $sub_category->id; 
        $course->price              = $request['price'];
        $course->exam_type_id       = $request['exam_type_id'];
        $course->certificate_type_id = $request['certificate_type_id'];
        
        //Save the course
        $course->save();
        
        //Send response to server
        return response()->json([
            'message' => 'New Course: '.$course->name.' has been created successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.exam')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
            ]);

    }

    public function destroy($id)
    {
        $course = Course::find($id);

        $course->delete();

        return response()->json([
            'message' => 'New Course: '.$course->name.' has been created successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
            ]);
    }
}
