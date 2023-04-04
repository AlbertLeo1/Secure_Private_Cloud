<?php

namespace App\Models\Lms;

use App\Models\Structure;

class Result extends Structure{
    protected $primaryKey = 'id';
    protected $table = 'results';
    protected $dates = array('created_at', 'updated_at', 'deleted_at');
    protected $fillable = array('user_id', 'exam_id','total_points', 'created_at', 'updated_at', 'deleted_at',);

    public function exam(){
        return $this->belongsTo('App\Models\Lms\Exam', 'exam_id', 'id');
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function questions(){
        return $this->belongsToMany('App\Models\Lms\Question')->withPivot(['option_id', 'points']);
    }

    public function answers(){
        return $this->hasMany('App\Models\Lms\QuestionResult', 'result_id', 'id');
    }

    public function full_brief(){
        return $this->hasMany('App\Models\Lms\QuestionResult', 'result_id', 'id');
    }
}