<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Exam;
use App\Models\Lms\Option;
use App\Models\Lms\Question;
use App\Models\Lms\QuestionType;

class OptionController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'option_text' => 'sometimes|string',
            'question_id'=> 'required|numeric',
            'points' => 'required|numeric',
        ]);

        $option = Option::create([
            'option_text' => $request->input('option_text'),
            'option_img' => $request->input('option_img'),
            'question_id'=> $request->input('question_id'),
            'points' => $request->input('points'),
        ]);
        

        $question = Question::find($request->input('question_id'));
        $exam = Exam::where('id', '=', $question->exam_id)->with('course')->with('lesson')->with('questions.options')->with('exam_type')->first();
        //$exam_types = ExamType::all();
        $question_types = QuestionType::all();
        return response()->json([
            'exam' => $exam,
            //'exam_types' => $exam_types,
            'question_types' => $question_types,
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'option_text' => 'sometimes|string',
            'question_id'=> 'required|numeric',
            'points' => 'required|numeric',
        ]);

        $option = Option::find($id);
    
        $option->option_text = $request->input('option_text');
        $option->option_img = $request->input('option_img');
        $option->question_id = $request->input('question_id');
        $option->points = $request->input('points');

        $option->save();
        
        $question = Question::find($request->input('question_id'));
        $exam = Exam::where('id', '=', $question->exam_id)->with('course')->with('lesson')->with('questions.options')->with('exam_type')->first();
        //$exam_types = ExamType::all();
        $question_types = QuestionType::all();
        return response()->json([
            'exam' => $exam,
            //'exam_types' => $exam_types,
            'question_types' => $question_types,
        ]);
    }

    public function destroy($id)
    {
        $option = Option::find($id);

        $option->delete();

        //Return General
        $question = Question::find($option->question_id);
        $exam = Exam::where('id', '=', $question->exam_id)->with('course')->with('lesson')->with('questions.options')->with('exam_type')->first();
        $question_types = QuestionType::all();
        return response()->json([
            'exam' => $exam,
            'question_types' => $question_types,
        ]);
    }
}
