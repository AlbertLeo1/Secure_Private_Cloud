<?php

namespace App\Models\Lms;

use App\Models\Structure;

class Option extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'options';
    protected $dates = array('created_at', 'updated_at', 'deleted_at');
    protected $fillable = array('points', 'question_id','option_text', 'created_at', 'updated_at', 'deleted_at',);

    public function question(){
        return $this->belongsTo('App\Models\Lms\Question', 'question_id', 'id');
    }   
}