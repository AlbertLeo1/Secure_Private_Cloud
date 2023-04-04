<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Employee extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_employees';
    protected $fillable = array('unique_id', 'line_manager_id', 'user_id', 'department_id', 'branch_id', 'official_email', 'street', 'street2', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at', 'city', 'nationality_id', 'qualification_id', 'designation_id', 'joined_date');

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

	public function bonuses(){
    	return $this->hasMany('App\Models\HRMS\Bonus', 'employee_id', 'id');
	}

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function line_manager(){
    	return $this->belongsTo('App\Models\HRMS\Employee', 'line_manager_id', 'id');
	}

    public function qualification(){
    	return $this->belongsTo('App\Models\HRMS\Qualification', 'qualification_id', 'id');
	}

	public function designation(){
    	return $this->belongsTo('App\Models\HRMS\Designation', 'designation_id', 'id');
	}

	public function department(){
    	return $this->belongsTo('App\Models\Department', 'department_id', 'id');
	}

	public function gross_salary(){
    	return $this->belongsTo('App\Models\HRMS\SalaryRate', 'salary_rate_id', 'id');
	}
}
