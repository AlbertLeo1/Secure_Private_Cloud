<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class IllnessCategory extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_illness_categories';
    protected $fillable = array('name', 'created_at', 'deleted_at');
}