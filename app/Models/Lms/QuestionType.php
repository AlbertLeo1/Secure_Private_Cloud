<?php

namespace App\Models\Lms;

use App\Models\Structure;

class QuestionType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'question_types';
    protected $fillable = array('name', 'description');

}
