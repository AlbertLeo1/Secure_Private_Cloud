<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'ticketit_statuses';
    protected $fillable = array('name', 'color', 'icon');
    
}
