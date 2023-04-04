<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_leaves';
    protected $fillable = [
        'employee_id', 'leave_type_id', 'from_date', 'to_date', 'hours_logged', 'reason', 'status', 'cc_to', 'point_of_contact', 'description', 'line_manager_id', 'subject', 'created_by', 'updated_by'
    ];

    public function leaveType()
    {
        return $this->belongsTo('App\Models\HRMS\LeaveType', 'leave_type_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\HRMS\Employee', 'employee_id', 'id');
    }

    public function pointOfContact()
    {
        return $this->belongsTo('App\Models\HRMS\Employee', 'point_of_contact', 'id');
    }

    public function lineManager()
    {
        return $this->belongsTo('App\Models\HRMS\Employee', 'line_manager_id', 'id');
    }
}
