<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTask extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'emr_patient_tasks';
    protected $fillable = array('patient_id', 'task_id', 'domiciliary', 'repeating', 'frequency_id', 'quantity', 'details', 'start_date', 'end_date', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function frequency(){
    	return $this->belongsTo('App\Models\EMR\Frequency', 'frequency_id', 'id');
	}
    
    public function task(){
    	return $this->belongsTo('App\Models\EMR\NursingTask', 'task_id', 'id');
	}
}
