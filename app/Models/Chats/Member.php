<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Member extends Structure{
    protected $primaryKey = 'id';
    protected $table = 'chat_room_members';
    protected $fillable = array('room_id', 'user_id', 'status', 'created_at', 'updated_at', 'deleted_at', 'deleted_by'); 

    public function room(){
        return $this->belongsTo('App\Models\Chats\Room', 'room_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
