<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_employee_types';
    protected $fillable = array( 'name', 'details', 'created_at', 'updated_at', 'deleted_at');
}
