<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// extends Model
use App\Models\Structure;

class DomiliciaryAccessmentBraden extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_domiliciary_accessment_bradens';
    protected $fillable = array('domiliciary_id', 'sensory_perception', 'moisture', 'activity', 'mobility', 'nutrition', 'friction_shear', 'score', 'remarks', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');
    
}