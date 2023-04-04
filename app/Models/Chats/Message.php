<?php

namespace App\Models\Chats;

use App\Models\Structure;

class Message extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'chat_messages';
    protected $fillable = array('room_id', 'user_id', 'content', 'status', 'created_at', 'updated_at', 'deleted_at', 'deleted_by'); 

    public function room(){
        return $this->belongsTo('App\Models\Chats\Room', 'room_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
