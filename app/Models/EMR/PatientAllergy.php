<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class PatientAllergy extends Structure
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'emr_patient_allergies';
    protected $fillable = array('patient_id', 'allergy_type_id', 'allergy', 'description', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');


}
