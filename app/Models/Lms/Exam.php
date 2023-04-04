<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Exam extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'exams';
    protected $fillable = array('name', 'status', 'description', 'course_id', 'lesson_id', 'question', 'pass_mark', 'trials');

    public function assignees(){
        return $this->hasMany('App\Models\Lms\UserExam', 'exam_id', 'id');
    } 

    public function course(){
        return $this->belongsTo('App\Models\Lms\Course', 'course_id', 'id');
    }  

    public function exam_type(){
        return $this->belongsTo('App\Models\Lms\ExamType', 'type_id', 'id');
    }
    
    public function lesson(){
        return $this->belongsTo('App\Models\Lms\Lesson', 'lesson_id', 'id');
    }  
    
    public function questions(){
        return $this->hasMany('App\Models\Lms\Question', 'exam_id', 'id');
    }  
    
    public function results(){
        return $this->hasMany('App\Models\Lms\Result', 'exam_id', 'id');
    }  

    public function tutors(){
        return $this->hasMany('App\Models\Lms\TutorExam', 'exam_id', 'id');
    }  
}
