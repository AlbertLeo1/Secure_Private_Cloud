<?php

namespace App\Models\EMR\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Structure;

class Assessment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_assessments';
    protected $fillable = array('patient_id', 'domiciliary_id', 'assigned_by', 'assigned_date', 'status', 'assessed_by', 'assessed_at', 'approved_by', 'approved_at', 'approval_status', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function assessed_by(){
    	return $this->belongsTo('App\Models\User', 'assessed_by', 'id');
	}
    
    public function assigned(){
    	return $this->belongsTo('App\Models\User', 'assigned_by', 'id');
	}
    
    public function dom(){
    	return $this->belongsTo('App\Models\EMR\Domiciliary', 'domiciliary_id', 'id');
	}
    
    public function patient(){
    	return $this->belongsTo('App\Models\EMR\Patient', 'patient_id', 'id');
	}
}