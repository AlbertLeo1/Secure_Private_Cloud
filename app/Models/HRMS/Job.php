<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_jobs';
    protected $fillable = [
        'title', 'description', 'skill', 'branch_id', 'designation_id', 'department_id', 'start_date', 'end_date', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function applicant()
    {
        return $this->hasMany('App\Models\HRMS\Applicant');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\HRMS\Department', 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Models\HRMS\Designation', 'designation_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id');
    }
}
