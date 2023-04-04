<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class ShiftType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_domiliciary_shift_types';
    protected $fillable = array('name', 'start_time', 'end_time', 'status', 'description', 'created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

}
