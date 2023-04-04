<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_designations';
    protected $fillable = [
        'designation_name', 'status',
    ];

    public function job()
    {
        return $this->hasMany('App\Models\HRMS\Job');
    }
}
