<?php

namespace App\Models\EMR\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeItem extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_assessment_type_items';
    protected $fillable = array('type_id', 'item_id', 'created_at', 'updated_at', 'deleted_at');    
}
