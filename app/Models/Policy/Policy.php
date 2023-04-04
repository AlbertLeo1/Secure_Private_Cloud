<?php

namespace App\Models\Policy;

use App\Models\Structure;

class Policy extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'policies';
    protected $fillable = array('name', 'file', 'category_id', 'description', 'created_by', 'updated_by', 'deleted_by', 'deleted_at');
    
    public function category(){
    	return $this->belongsTo('App\Models\PolicyCategory', 'category_id', 'id'); 
	}
    
    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id'); 
	}

    public function depts(){
    	return $this->HasMany('App\Models\Policy\PolicyDepartment', 'policy_id', 'id'); 
	}

    public function departments(){
    	return $this->HasManyThrough('App\Models\Policy\PolicyDepartment', 'App\Models\Department', 'id', 'department_id', 'policy_id', 'id',); 
	}

    public function updater(){
    	return $this->belongsTo('App\Models\User', 'id', 'updated_by'); 
	}
}