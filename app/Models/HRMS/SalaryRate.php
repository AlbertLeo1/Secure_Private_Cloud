<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class SalaryRate extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_salary_rates';
    protected $fillable = array('name', 'amount', 'type', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
}
