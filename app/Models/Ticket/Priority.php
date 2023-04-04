<?php

namespace App\Models\Ticket;

use App\Models\Structure;
//use Illuminate\Database\Eloquent\Model;

class Priority extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'ticketit_priorities';
    protected $fillable = array('name', 'color', 'created_at', 'updated_at', 'deleted_at');

}
