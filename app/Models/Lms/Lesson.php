<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Lesson extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'lessons';
    protected $fillable = array('name', 'course_id', 'lesson_type_id', 'file_type', 'file', 'video', 'content', 'serial_number', 'grave', 'created_by', );
    public function course(){
    	return $this->belongsTo('App\Models\Lms\Course', 'course_id', 'id'); 
        }
    
    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id'); 
        }

    public function exam(){
        return $this->hasOne('App\Models\Lms\Exam', 'lesson_id', 'id'); 
        }

    public function reads(){
        return 0;
        //$this->hasMany('App\Models\Lms\LessonReads', 'lesson_id', 'id'); 
        }
	}