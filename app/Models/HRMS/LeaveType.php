<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_leave_types';
    protected $fillable = ['name', 'amount', 'description', 'status', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    public function employees()
    {
        return $this->belongsToMany('App\Models\HRMS\Employee')
            ->withTimestamps();
    }

    public function requests(){
        return $this->hasMany('App\Models\HRMS\Leave', 'leave_type_id', 'id')
            ->withTimestamps();
    }
}
