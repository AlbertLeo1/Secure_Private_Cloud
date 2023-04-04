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
use App\Models\User;

class LessonController extends Controller
{
    public function index()
    {
        /*return response()->json([
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
            ]);*/
    }

    public function modify(Request $request)
    {
        
        $data = json_decode($request->input('data'));

        $upload_path = "upload/lessons";

        if((is_null($request->file)) || ($request->file == "")){$file_full = null;}
        else{
            $fileName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path($upload_path), $fileName);
            $file_full = '/'.$upload_path.'/'.$fileName;
        }

        $data = json_decode($request->input('data'));
        //print_r($data);
        $lesson = Lesson::find($data->id);
        $lesson->name = $data->name; 
        $lesson->course_id = $data->course_id; 
        $lesson->content = $data->content;
        $lesson->lesson_type_id = $data->lesson_type_id;
        $lesson->file_type = $request->input('file_type');
        $lesson->video = $data->video ?? null;
        $lesson->file = $file_full;
        $lesson->serial_number = null;
        $lesson->updated_by = auth('api')->id();

        $lesson->save();
        
        return response()->json([
            'message' => 'New Lesson: '.$lesson->name.' has been created successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),  
            'course' => Course::where('id', '=', $lesson->course_id)->with('lessons')->first(),     
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
        ]);
    }

    public function fileUpload(Request $request)
    {
        print_r($request->input());
        if((is_null($request->file)) || ($request->file == "")){
            $file_type = null;
            $fileName = null;
        }
        else{
            echo $fileName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('upload'), $fileName);

            $upload_path = public_path('upload');
            
            $img = array('gif', 'png', 'jpg', 'jpeg');
            $pdf = array('pdf');
            $doc = array('doc', 'docx', 'xls', 'xlsx', 'csv');

            $ext = $request->file->getClientOriginalExtension();
            if (in_array($ext, $img)) { $file_type = 'image';}
            else if (in_array($ext, $pdf)) { $file_type = 'pdf';}
            else if (in_array($ext, $doc)) { $file_type = 'doc';}
            else { $file_type = 'others';}
        }

        $request['data'] = json_decode($request['data']);

        if (is_null($request->input('data.id'))){ 
            $lesson = Lesson::create([
                'name' => $request->input('data.name'), 
                'course_id' => $request->input('data.course_id'), 
                'content' => $request->input('data.content'), 
                'lesson_type_id' => $request->input('data.lesson_type_id'),
                'file_type' => $file_type,
                'video' => $request->input('data.video'),
                'file' => is_null($fileName) ? null : 'upload/'.$fileName,
                'serial_number' => null,
            ]);

            $message = "A new module ".$lesson->name." has been successfully created";
        }
        else{
            $lesson = Lesson::find($request->input('data.id'));

            $lesson->name = $request->input('data.name');
            $lesson->course_id = $request->input('data.course_id'); 
            $lesson->content = $request->input('data.content');
            $lesson->lesson_type_id = $request->input('data.lesson_type_id');
            $lesson->file_type = $file_type;
            $lesson->video = $request->input('data.video');
            if (!is_null($fileName)){$lesson->file = 'upload/'.$fileName;}

            $lesson->save();
            
            $message = "The module ".$lesson->name." has been successfully updated.";
        }

        $course = Course::find($lesson->course_id)->with('lessons')->get();
        return response()->json([
            'course' => $course,
            'icon' => 'success',
            'lesson' => $lesson,
            'success' => $message,
        ]);
    }

    public function store(Request $request)
    {
        
        $data = json_decode($request->input('data'));

        $upload_path = "upload/lessons";

        if((is_null($request->file)) || ($request->file == "")){$file_full = null;}
        else{
            $fileName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path($upload_path), $fileName);
            $file_full = '/'.$upload_path.'/'.$fileName;
        }

        $data = json_decode($request->input('data'));
        $lesson = Lesson::create([
            'name' => $data->name, 
            'course_id' => $data->course_id, 
            'content' => $data->content, 
            'lesson_type_id' => 1,
            'file_type' => $request->input('file_type'),
            'video' => $data->video ?? null,
            'file' => $file_full,
            'serial_number' => null,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);
    
        return response()->json([
            'message' => 'New Lesson: '.$lesson->name.' has been created successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),  
            'course' => Course::where('id', '=', $lesson->course_id)->with('lessons')->first(),     
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),  
            'lesson' => Lesson::where('id', '=', $id)->with('creator')->with('course')->with('exam')->first(),
            'users' => User::all(),
        ]);
    }

    public function fileStore(Request $request)
    {
        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move($upload_path, $generated_new_name);
        
        $img = array('gif', 'png', 'jpg', 'jpeg');
        $pdf = array('pdf');
        $doc = array('doc', 'docx', 'xls', 'xlsx', 'csv');


        $ext = $request->file->getClientOriginalExtension();
        if (in_array($ext, $img)) { $file_type = 'image';}
        else if (in_array($ext, $pdf)) { $file_type = 'pdf';}
        else if (in_array($ext, $doc)) { $file_type = 'doc';}
        else { $file_type = 'others';}

        //$insert['title'] = $file_name;
        
        return response()->json([
            'success' => 'You have successfully uploaded "' . $file_name . '"',
            'file' => $upload_path.'/'.$generated_new_name,
            'file_type' => $file_type
            ]);
    }

    public function update(Request $request, $id)
    {
        /*$this->validate($data, [
            'id' => 'required', 
            'lesson_type_id' => 'required', 
            'name' => 'required', 
            'course_id' => 'required',
            'video' => 'string', 
            'content' => 'required',
        ]);*/
        $data = json_decode($request->input('data'));
        print($request->file);
        $lesson = Lesson::find($id);
        
        $data = json_decode($request->input('data'));
        print_r($data);
        
        //print ($request);
        $upload_path = "upload/lessons/";
        if((is_null($request->file)) || ($request->file == "")){$file_type = null; $fileName = null;}
        else{$fileName = time().'.'.$request->file->getClientOriginalExtension(); $request->file->move(public_path($upload_path), $fileName);}
        
        $lesson = Lesson::find($id);
        print_r($lesson);
        $lesson->name           = $data->name;
        $lesson->course_id      = $data->course_id;
        $lesson->content        = $data->content;
        $lesson->video          = $data->video;
        $lesson->lesson_type_id = $data->lesson_type_id;
        $lesson->file_type      = $data->file_type;
        $lesson->file           = $data->file;
        //$lesson->serial_number = null;
        
        //Save the course
        $lesson->save();
        
        //Send response to server
        return response()->json([
            'success' => 'Lesson: '.$lesson->name.' has been edited successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'course' => Course::where('id', '=', $lesson->course_id)->with('lessons')->first(),     
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'lesson' => $lesson,
            //'users' => User::all(),
        ]);
    }

    public function destroy($id)
    {
        $lesson = lesson::find($id);

        $lesson->delete();

        return response()->json([
            'message' => 'New Lesson: '.$lesson->name.' has been created successfully',
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'courses' => Course::with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20),       
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
            'course' => Course::find($lesson->course_id)->with('lessons'),
        ]);
    }
}
