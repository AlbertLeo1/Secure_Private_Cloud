<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class MonthSalary extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_monthly_salaries';
    protected $fillable = array('month', 'employee_id', 'gross_salary', 'leave_deduction', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function employee(){
    	return $this->belongsTo('App\Models\HRMS\Employee', 'employee_id', 'id');
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
}
