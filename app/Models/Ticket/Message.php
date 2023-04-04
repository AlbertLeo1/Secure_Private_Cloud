<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Message extends  Structure
{
    protected $primaryKey = 'id';
    protected $table = 'ticketit_messages';
    protected $fillable = array('subject', 'message', 'phone', 'contact_type', 'email', 'first_name', 'last_name', 'contact_type', 'created_at', 'updated_at', 'deleted_at', 'deleted_by', 'responded_at', 'responded_by');     
}