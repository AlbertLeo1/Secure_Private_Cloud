<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'departments';
    protected $fillable = array('name', 'hod_id', 'description', 'ext', 'email', 'deleted_by', 'deleted_at');
	
    public function users(){
    	return $this->hasMany('App\Models\User', 'department_id', 'id');
		}
	public function hod(){
		return $this->belongsTo('App\Models\User', 'hod_id', 'id');
		}
	}