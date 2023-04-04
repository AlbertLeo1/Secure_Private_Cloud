<?php

namespace App\Models\Policy;

use Illuminate\Database\Eloquent\Model;

class PolicyDepartment extends Model
{
    protected $table = 'policy_departments';
    protected $fillable = array('policy_id', 'department_id', 'created_by');
    
    public function policy(){
    	return $this->hasOne('App\Models\Policy\Policy', 'id', 'policy_id'); 
	}

    public function department(){
    	return $this->hasOne('App\Models\Department', 'id', 'department_id'); 
	}

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'id', 'updated_by'); 
	}
}