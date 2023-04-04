<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Batch extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_batches';
    protected $fillable = array( 'patient_id', 'shift_type_id', 'staff_type_id', 'start_date', 'end_date', 'status', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function patient(){
    	return $this->belongsTo('App\Models\EMR\Patient', 'patient_id', 'id');
	}

    public function shift_type(){
    	return $this->belongsTo('App\Models\EMR\ShiftType', 'shift_type_id', 'id');
	}

    public function staff_type(){
    	return $this->belongsTo('App\Models\HRMS\EmployeeType', 'staff_type_id', 'id');
	}

    public function tasks(){
    	return $this->hasManyThrough('App\Models\EMR\PatientTask', 'App\Models\EMR\BatchActivity', 'batch_id', 'id', 'patient_task_id', 'batch_id');
	}

    public function activities(){
    	return $this->hasMany('App\Models\EMR\BatchActivity', 'batch_id', 'id');
	}
    
}
