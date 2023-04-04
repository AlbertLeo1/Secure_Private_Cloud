<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Structure;

class Applicant extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_applicants';

    protected $fillable = [
        'name', 'fname', 'avatar', 'city', 'cv', 'job_status', 'job_id', 'recruited', 'email',
    ];
    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->belongsTo('App\Models\HRMS\Job');
    }
}
