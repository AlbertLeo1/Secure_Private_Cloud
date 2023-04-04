<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Course extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'courses';
    protected $fillable = array('name', 'category_id', 'sub_category_id', 'price', 'exam', 'exam_type_id', 'certificate_type_id', 'description');
        
    public function assignees(){
        return $this->hasMany('App\Models\Lms\UserCourse', 'course_id', 'id');
        }

    public function category(){
    	return $this->belongsTo('App\Models\Lms\Category', 'category_id', 'id'); 
		}
    
    public function lessons(){
        return $this->hasMany('App\Models\Lms\Lesson', 'course_id', 'id');
        }

    public function sub_category(){
    	return $this->belongsTo('App\Models\Lms\SubCategory', 'sub_category_id', 'id'); 
		}

    public function subscribers()
    {
        return $this->hasManyThrough(
            'App\Models\User', 
            'App\Models\Lms\UserCourse', 
            'course_id', //Foreign key on UserCourse
            'id', //Foreign key on User table
            'id', // Local key on Course table
            'user_id', //Local key on User Course 
        );
    }

    public function tutors(){
        return $this->hasMany('App\Models\Lms\TutorCourse', 'course_id', 'id');
    }
    
    
}
