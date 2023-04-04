<?php

namespace App\Models\EMR\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Structure;

class AssessmentType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_assessment_types';
    protected $fillable = array('name', 'description', 'created_by', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function assessments(){
    	return $this->hasManyThrough('App\Models\EMR\Assessment\Item','App\Models\EMR\Assessment\TypeItem', 'type_id', 'id', 'id', 'item_id');
	}

    public function creator(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
}