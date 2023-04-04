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
use App\Models\Lms\Question;
use App\Models\Lms\QuestionType;
use App\Models\Lms\SubCategory;
use App\Models\Lms\TutorCourse;
use App\Models\Lms\TutorExam;
use App\Models\User;

class TutExamController extends Controller
{
    public function index()
    {
        $tutor_exam_id = TutorExam::select('exam_id')->where('tutor_id', '=', auth('api')->id())->get();
        $exams = Exam::wherein('id', $tutor_exam_id)->with('assignees.user')->with('tutors.tutor.department')->with('course')->with('lesson')->orderBy('name', 'ASC')->paginate(20);
        $question_types = QuestionType::all();
        
        return response()->json([
            'courses'           => Course::with('lessons')->orderBy('name', 'ASC')->get(),
            'exam_types'        => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'exams'             => $exams,
            'question_types'    => $question_types,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $course = Course::where('id', '=', $id)->with('assignees')->with('tutors')->with('lessons')->first();
        $tut_courses = TutorCourse::where('tutor_id', '=', auth('api')->id())->with('course')->get();
        $tut_course_id = TutorCourse::select('course_id')->where('tutor_id', '=', auth('api')->id())->get();
        $courses = Course::whereIn('id', $tut_course_id)->with('assignees.user')->with('tutors.tutor.department')->with('category.sub_categories')->with('lessons.course')->with('sub_category')->orderBy('name', 'ASC')->paginate(20);

        return response()->json([
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'course' => $course,
            'courses' => $courses,
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
        ]);

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
