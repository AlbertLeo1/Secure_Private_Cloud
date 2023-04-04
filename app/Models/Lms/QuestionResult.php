<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;

class QuestionResult extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'question_result';
    protected $fillable = array('question_id', 'option_id', 'result_id', 'points');
    
    public function option(){
        return $this->belongsTo('App\Models\Lms\Option', 'id', 'option_id');
    }

    public function question(){
        return $this->belongsTo('App\Models\Lms\Question', 'question_id', 'id');
    }   
}
