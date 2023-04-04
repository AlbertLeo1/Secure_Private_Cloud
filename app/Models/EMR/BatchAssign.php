<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchAssign extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_batch_daily_assignments';
    protected $fillable = array( 'batch_id', 'staff_id', 'date', 'status', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function batch(){
    	return $this->belongsTo('App\Models\EMR\Batch', 'batch_id', 'id');
	}
    
    public function staff(){
    	return $this->belongsTo('App\Models\HRMS\Employee', 'staff_id', 'id');
	}

    public function patient(){
    	return $this->hasOneThrough('App\Models\EMR\Patient', 'App\Models\EMR\Batch', 'id', 'id', 'batch_id', 'patient_id');
	}

    public function shift_type(){
    	return $this->hasOneThrough('App\Models\EMR\ShiftType', 'App\Models\EMR\Batch', 'id', 'id', 'batch_id', 'shift_type_id');
	}
	
    public function staff_type(){
    	return $this->hasOneThrough('App\Models\HRMS\EmployeeType', 'App\Models\EMR\Batch',  'id', 'id', 'batch_id', 'staff_type_id');
	}
}
