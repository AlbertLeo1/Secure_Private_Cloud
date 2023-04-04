<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Model;

class PrescriptionDrug extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_prescription_drugs';
    protected $fillable = array('prescription_id', 'drug_id', 'drug_name', 'detail', 'dose', 'duration', 'frequency', 'form',  'route', 'quantity', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at');
}
 