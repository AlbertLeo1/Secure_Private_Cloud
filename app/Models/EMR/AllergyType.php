<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Structure;

class AllergyType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_allergy_types';
    protected $fillable = array('name', 'description', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');
}