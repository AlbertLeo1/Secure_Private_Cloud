<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class UserExam extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'user_exams';
    protected $fillable = array('user_id', 'exam_id', 'course_id', 'lesson_id', 'assigned_date', 'start_date', 'expiry_date', 'user_start_time', 'user_finish_time', 'status');
    
    public function course(){
    	return $this->belongsTo('App\Models\Lms\Course', 'course_id', 'id'); 
    }
    
    public function exam(){
    	return $this->belongsTo('App\Models\Lms\Exam', 'exam_id', 'id'); 
		}
    
    public function lesson(){
    	return $this->belongsTo('App\Models\Lms\Lesson', 'lesson_id', 'id'); 
		}
    
    public function trials(){
    	return $this->hasMany('App\Models\Lms\Result', 'user_id', 'id'); 
        }
    
    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id'); 
        }
    
}