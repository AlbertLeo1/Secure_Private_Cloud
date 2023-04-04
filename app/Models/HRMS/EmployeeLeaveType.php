<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveType extends Model
{
    //protected $primaryKey = ['user_id', 'stock_id'];
    //public $incrementing = false;

    protected $table = 'hrms_employee_leave_types';

    protected $fillable = [
        'employee_id', 'leave_type_id', 'count', 'status',
    ];

    public function leave_type(){
    	return $this->belongsTo('App\Models\HRMS\LeaveType', 'leave_type_id', 'id');
	}
}
