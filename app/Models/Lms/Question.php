<?php

namespace App\Models\Lms;

use App\Models\Structure;

class Question extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'questions';
    protected $fillable = array('type_id', 'question', 'question_img', 'exam_id');

    public function type(){
    	return $this->belongsTo('App\Models\Lms\QuestionType', 'type_id', 'id'); 
        }
    
    public function options(){
        return $this->hasMany('App\Models\Lms\Option', 'question_id', 'id');
    }

    public function questionsResults(){
        return $this->belongsToMany('App\Models\Lms\Result', );
    }   
}
