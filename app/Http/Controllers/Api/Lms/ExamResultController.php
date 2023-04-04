<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Course;
use App\Models\Lms\Exam;
use App\Models\Lms\ExamType;
use App\Models\Lms\Option;
use App\Models\Lms\Question;
use App\Models\Lms\QuestionType;
use App\Models\Lms\Result;

class ExamResultController extends Controller
{
    public function index()
    {
        return response()->json([
            'results' => Result::where('exam_id', '=', $_GET['r'])->with('exam')->with('user')->paginate(5),       
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return response()->json([
            'result' => Result::where('id', '=', $id)->with('exam.questions')->with('answers.question.options')->with('user')->first(),
        ]);
        /*
        return response()->json([
            'categories' => Category::select('id', 'name',)->with('sub_categories')->orderBy('name', 'ASC')->get(),       
            'certificate_types' => CertificateType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'course' => Course::where('id', '=', $id)->with('assignees.user')->with('tutors.tutor')->with('lessons.exam')->with('category')->with('sub_category')->first(),
            'departments' => Department::select('id', 'name')->with('users')->get(),
            'exam_types' => ExamType::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'users' => User::all(),
        ]);*/

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
