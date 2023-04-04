<?php

namespace App\Models\Lms;

use App\Models\Structure;

class UserLesson extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'user_lessons';
    protected $fillable = array('user_id', 'lesson_id', 'exam_id', 'start_date', 'user_start_time', 'user_finish_time', 'status', 'deleted_at');
    
    public function exam(){
    	  return $this->belongsTo('App\Models\Lms\Exam', 'exam_id', 'id'); 
		}
    
    public function lesson(){
    	  return $this->belongsTo('App\Models\Lms\Lesson', 'lesson_id', 'id'); 
		}
    
    public function user(){
    	  return $this->belongsTo('App\Models\User', 'user_id', 'id'); 
    }   
}