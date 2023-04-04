<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_deductions';
    protected $fillable = array('employee_id', 'name', 'amount', 'description', 'month', 'created_by', 'updated_by', 'deleted_by', 'deleted_at');

    public function employee(){
    	return $this->belongsTo('App\Models\HRMS\Employee', 'employee_id', 'id');
	}
}
