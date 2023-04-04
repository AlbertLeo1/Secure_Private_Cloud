<?php

namespace App\Models\EMR\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Structure;

class HealthSubstance extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_assessment_health_substances';
    protected $fillable = array('patient_id', 'domiciliary_id', 'product_name', 'harm_type', 'substance_form', 'substance_colour', 'causes_harm', 'contact', 'frequency', 'substance_use', 'safer_alternative', 'controls', 'emergency_procedure', 'staff_aware', 'reduced_risk', 'further_actions', 'created_by', 'created_at', 'updated_by', 'updated_at', 'approved_by', 'approved_at', 'deleted_by', 'deleted_at');
}