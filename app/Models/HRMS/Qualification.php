<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Qualification extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_qualifications';
    protected $fillable = array('name', 'description', 'created_by', 'updated_by', 'deleted_by', 'status', 'created_at', 'updated_at', 'deleted_at');

}
