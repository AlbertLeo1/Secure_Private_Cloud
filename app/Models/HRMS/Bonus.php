<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Bonus extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_bonuses';
    protected $fillable = array('employee_id', 'name', 'amount', 'description', 'month', 'created_by', 'updated_by', 'deleted_by', 'deleted_at');

    public function employee(){
    	return $this->belongsTo('App\Models\HRMS\Employee', 'employee_id', 'id');
	}
}
