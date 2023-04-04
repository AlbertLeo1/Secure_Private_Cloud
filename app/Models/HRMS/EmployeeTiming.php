<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class EmployeeTiming extends Model
{
    protected $fillable = [
        'employee_id', 'day', 'timing_start', 'timing_off',
    ];

    public function employee()
    {
        return $this->hasMany('App\Models\HRMS\Employee');
    }
}
