<?php

namespace App\Http\Controllers\Std;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Exam;
use App\Models\Lms\Option;
use App\Models\Lms\QuestionResult;
use App\Models\Lms\Result;
use App\Models\Lms\UserCourse;
use App\Models\Lms\UserExam;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        $options = Option::find(array_values($request->input('questions')));
        
        $exam = Exam::find($request->input('exam_id'));

        $result = Result::create([
            'user_id' => Auth()->id(),
            'exam_id' => $request->input('exam_id'),
            'total_points' => $options->sum('points'),
        ]);

        $questions = $options->mapWithKeys(function ($option) {
            return [$option->question_id => ['option_id' => $option->id, 'points' => $option->points]];
            })->toArray();

        $result->questions()->sync($questions);
         
        $resort = Result::where('id', '=', $result->id )->first();

        if ($exam->pass_mark <= $options->sum('points')){
            $user_exam = UserExam::where('exam_id', '=', $exam->id)->where('user_id', '=', Auth()->id())->with('lesson')->with('course')->first();
            //Check if the exam had been passed before
            if ($user_exam->status == 3){
                //Do Nothing For Now
            }
            else if (($user_exam->status == 6) || ($user_exam->status == 2)){
                //Update result status
                if (($user_exam->status == 2) && (!is_null($user_exam->lesson))){
                    $user_course = UserCourse::where('course_id', '=', $user_exam->course_id)->where('user_id', '=', Auth()->id())->first();
                    $user_course->level++;
                    $user_course->save();
                }

                //Update the exam to be passed
                $user_exam->status = 3;
                $user_exam->user_finish_time = date('Y-m-d H:i:s');
                $user_exam->save();
            }
            else if ($user_exam->status == 2){
                $user_exam->status = 3;
                
            }
            if ($user_exam->status != 3){
                
            }
        }
        
        $exams = QuestionResult::where('result_id', '=', $resort->id)
            ->leftJoin('options', 'options.id', '=', 'question_result.option_id')
            ->leftJoin('questions', 'questions.id', '=', 'question_result.question_id')
            ->select('question_result.*', 'options.option_text', 'questions.question')
            ->get();

        $params = [
            'exam' => $exam,
            'exams' => $exams,
            'resort' => $resort,
            'result' => $result,
            'page_title' => "Exam Result", 
        ];

        return view('learn.result')->with($params);
    }

    public function show($id)
    {
        //Check if this user can do this exam
        $user_exam = UserExam::where('user_id', '=', Auth::id())->where('exam_id', '=', $id)->with('exam')->get();

        if (count ($user_exam) == 0){
            return view ('lms.students.no-exam');
        }
        
        //Check If User Start Time is Set
        if(is_null($user_exam[0]->user_start_time)) {$user_exam[0]->user_start_time = date('Y-m-d H:i:s');}
        //Check if Status is Set to In Progress
        if($user_exam[0]->status < 2){ $user_exam[0]->status = 2;}
        //Save User Exam 
        $user_exam[0]->save();
        
        //print_r($user_exam[0]);

        $exam_list = Exam::where('id', '=', $id)->with('questions.options')->get();
        
        $exams = Exam::where('id', '=', $id)->with(['questions' => function ($query){
            $query->inRandomOrder()->with([
                'options' => function ($query){$query->inRandomOrder();}]);
            }]);
                
        $params = [
            'exams' => $exams,
            'exam_list' => $exam_list,
            'page_title' => 'Student Exam',
            ];

        return view('learn.exam')->with($params);
    }

    public function edit($id)
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
}
