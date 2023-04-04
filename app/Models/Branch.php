<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'branches';
    protected $fillable = array('name', 'address', 'unique_id', 'cinc_id', 'pm_id', 'hon_id', 'current', 'status');
	
	public function chief_consultant(){
		return $this->belongsTo('App\Models\User', 'cinc_id', 'id');
	}

	public function head_nurse(){
		return $this->belongsTo('App\Models\User', 'hon_id', 'id');
	}

	public function practice_manager(){
		return $this->belongsTo('App\Models\User', 'pm_id', 'id');
	}

	public function users(){
    	return $this->hasMany('App\Models\User', 'branch_id', 'id');
	}
	
	
}