<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchActivity extends Model
{
    protected $table = 'emr_batch_activities';
    protected $fillable = array( 'patient_task_id', 'batch_id');

        
    public function task_details(){
    	return $this->belongsTo('App\Models\EMR\NursingTask', 'patient_task_id', 'id');
	}

}
