<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class ExamType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'exam_types';
    protected $fillable = array('name', 'description',);
    public function exams(){
    	return $this->hasMany('App\Models\Lms\Exam', 'type_id', 'id'); 
		}
}
