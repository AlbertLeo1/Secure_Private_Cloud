<?php

namespace App\Models\Ticket;

use App\Models\Structure;

//use Illuminate\Database\Eloquent\Model;

class Update extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'ticketit_comments';
    protected $fillable = array('subject', 'status_id', 'ticket_id','type_id', 'user_id', 'content', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function stat(){
        return $this->belongsTo('App\Models\Ticket\Status', 'status_id', 'id');
    }
}
