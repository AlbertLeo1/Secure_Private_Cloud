<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugForm extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_drug_forms';
    protected $fillable = array('id', 'name', 'description');

}
