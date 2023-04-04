<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_skills';
    protected $fillable = [
        'skill_name', 'status', 'description',
    ];
}
