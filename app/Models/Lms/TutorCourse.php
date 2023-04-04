<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class TutorCourse extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'tutor_courses';
    protected $fillable = array('tutor_id', 'course_id', 'created_by', 'start_date', 'end_date',);
    
    public function course(){
    	return $this->belongsTo('App\Models\Lms\Course', 'course_id', 'id'); 
		}
    
    public function tutor(){
    	return $this->belongsTo('App\Models\User', 'tutor_id', 'id'); 
    }
    
}