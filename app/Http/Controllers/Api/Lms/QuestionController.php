<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Course;
use App\Models\Lms\Exam;
use App\Models\Lms\Option;
use App\Models\Lms\Question;
use App\Models\Lms\QuestionType;

class QuestionController extends Controller
{
    public function index()
    {
        return response()->json(['question_types' => QuestionType::all(),]);
    }

    public function store(Request $request)
    {
        $question_img = $request->input('question_img');

        $question = Question::create([
            'question' => $request->input('question'),
            'question_img' => $question_img,
            'exam_id' => $request->input('exam_id'),
            'type_id' => $request->input('question_type_id'),
        ]);

        $exam = Exam::where('id', '=', $question->exam_id)->with('course')->with('lesson')->with('questions.options')->with('exam_type')->first();
        $questions = Question::where('exam_id', '=', $request->input('exam_id'))->with('options')->get();
        $question_types = QuestionType::all();

        return response()->json([
            'exam' => $exam,
            'questions' => $questions,
            'question_types' => $question_types,
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        
        $question_img = $request->input('question_img');

        $question->question = $request->input('question');
        $question->question_img = $question_img;
        $question->exam_id = $request->input('exam_id');
        $question->type_id = $request->input('question_type_id');

        $question->save();

        $questions = Question::where('exam_id', '=', $request->input('exam_id'))->with('options')->get();
        
        $exam = Exam::where('id', '=', $question->exam_id)->with('course')->with('lesson')->with('questions.options')->with('exam_type')->first();
        $question_types = QuestionType::all();

        return response()->json(['exam' => $exam, 'question_types' => $question_types,]);
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();

        return response()->json([
            'courses' => Course::with('lessons')->orderBy('name', 'ASC')->get(),
            'exam' => Exam::where('id', '=', $question->exam_id)->with('lesson')->with('course')->with('questions.options')->first(),  
            'exam_types' => ExamType::all(),
            'question_types' => QuestionType::all(),
        ]);
    }
}
