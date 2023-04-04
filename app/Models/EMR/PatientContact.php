<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientContact extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'emr_patient_contacts';
    protected $fillable = array('patient_id', 'name', 'address', 'phone', 'alt_phone', 'email_address', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');
}
