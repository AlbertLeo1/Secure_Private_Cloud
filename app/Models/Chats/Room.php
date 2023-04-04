<?php

namespace App\Models\Chats;

use App\Models\Structure;

class Room extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'chat_rooms';
    protected $fillable = array('name', 'description', 'status', 'created_by', 'created_at', 'updated_at', 'deleted_at', 'deleted_by'); 

    public function members(){
        return $this->hasMany('App\Models\Chats\Member', 'room_id', 'id');
    }

    public function messages(){
        return $this->hasMany('App\Models\Chats\Message', 'room_id', 'id');
    }

    public function creator(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
}
