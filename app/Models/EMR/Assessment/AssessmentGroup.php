<?php

namespace App\Models\EMR\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Structure;

class Group extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_assessment_groups';
    protected $fillable = array('name', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'assessed_by', 'id');
	}
    
    public function updator(){
    	return $this->belongsTo('App\Models\User', 'assigned_by', 'id');
	}
    
    public function items(){
    	return $this->hasManyThrough('App\Models\EMR\Assessment\Item', 'App\Models\EMR\Assessment\GroupItem');
	}
    
    public function patient(){
    	return $this->belongsTo('App\Models\EMR\Patient', 'patient_id', 'id');
	}
}