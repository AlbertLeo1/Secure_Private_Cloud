<?php

namespace App\Models\EMR\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
<<<<<<< HEAD
    use HasFactory;
=======
    protected $primaryKey = 'id';
    protected $table = 'emr_assessment_items';
    protected $fillable = array('name', 'description', 'created_by', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function assessments(){
    	return $this->hasManyThrough('App\Models\EMR\Assessment\Item','App\Models\EMR\Assessment\TypeItem');
	}
>>>>>>> 8cad6ea9e48a845b53f44a9f19de5fafa0878a12
}
