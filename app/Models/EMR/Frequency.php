<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;
class Frequency extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_frequencies';
    protected $fillable = array('name', 'description');

}
