<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Structure;

class Agency extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_agencies';
    protected $fillable = array('name', 'agency_type_id', 'owner_id', 'status', 'created_at', 'created_by', 'confirmed_by', 'confirmed_at', 'flagged_by', 'flagged_at', 'deleted_by', 'deleted_at');
}