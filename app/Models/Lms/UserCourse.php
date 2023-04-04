<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class UserCourse extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'user_courses';
    protected $fillable = array('user_id', 'course_id', 'level', 'assigned_date', 'start_date', 'expiry_date', 'user_start_time', 'user_finish_time', 'status');
    
    public function course(){
    	return $this->belongsTo('App\Models\Lms\Course', 'course_id', 'id'); 
        }
    
    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id'); 
		}
}