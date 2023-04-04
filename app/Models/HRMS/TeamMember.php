<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'employee_id', 'team_id',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\HRMS\Employee');
    }
}
