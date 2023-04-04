<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Exam;
use App\Models\Lms\ExamType;
use App\Models\Lms\Question;
use App\Models\Lms\QuestionType;
use App\Models\Lms\UserExam;

class StdExamController extends Controller
{
    public function index()
    {
        $exams = UserExam::where('user_id', '=', auth('api')->id())
                ->with('exam')->with('course')->with('lesson')
                ->paginate(10);
        $exam_types = ExamType::all();
        $question_types = QuestionType::all();
        return response()->json([
            'exams' => $exams,
            'exam_types' => $exam_types,
            'question_types' => $question_types,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $exam = Exam::find($id);
        $num_question = count(Question::where('exam_id', '=', $id)->get());
        //echo $exam->question;
        if (($exam->status <= 2 )||( $exam->question > $num_question)){
            return response()->json([
                'exam' => $exam,
                'message' =>"Not Enough Questions/Exam is not currently active"]);
        }
        else{
            $questions = Question::select('id', 'type_id', 'question', 'question_img', 'opt_a',  'opt_b',  'opt_c',  'opt_d',  'opt_e')->where('exam_id', '=', $id)->inRandomOrder()->take($exam->question)->get();
            return response()->json([
                'exam' => $exam,
                'message' =>"Are you ready to do this?",
                'questions' => $questions,
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'description' => 'sometimes',
        ]);

        //Update the Exam
        $exam = Exam::find($id);
        
        $exam->name = $request['name'];
        $exam->status = $request['status'];
        $exam->description = $request['description'];

        $exam->save();

        //Return General
        $exams = Exam::orderBy('name', 'ASC')->with('course')->with('lesson')->with('questions.type')->with('exam_type')->paginate(5);
        $exam_types = ExamType::all();
        $question_types = QuestionType::all();
        return response()->json([
            'exams' => $exams,
            'exam_types' => $exam_types,
            'question_types' => $question_types,
        ]);
    }

    public function destroy($id)
    {
        $exam = exam::find($id);

        $exam->delete();

        //Return General
        $exams = Exam::orderBy('name', 'ASC')->with('course')->with('lesson')->with('questions.type')->with('exam_type')->paginate(5);
        $exam_types = ExamType::all();
        $question_types = QuestionType::all();
        return response()->json([
            'exams' => $exams,
            'exam_types' => $exam_types,
            'question_types' => $question_types,
        ]);
    }

}
