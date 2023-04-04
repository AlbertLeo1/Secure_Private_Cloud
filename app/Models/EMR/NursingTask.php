<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class NursingTask extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_nursing_tasks';
    protected $fillable = array('name', 'description', 'icons', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');
}
