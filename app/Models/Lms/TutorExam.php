<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class TutorExam extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'tutor_exams';
    protected $fillable = array('tutor_id', 'exam_id', 'assigned_date', 'created_by', 'deleted_by');
    
    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id'); 
	}
    
    public function exam(){
    	return $this->belongsTo('App\Models\Lms\Exam', 'exam_id', 'id'); 
	}
    
    public function removed_by(){
    	return $this->belongsTo('App\Models\User', 'deleted_by', 'id'); 
	}
    
    public function tutor(){
    	return $this->belongsTo('App\Models\User', 'tutor_id', 'id'); 
    }
    
}