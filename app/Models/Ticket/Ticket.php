<?php

namespace App\Models\Ticket;

//use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Ticket extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'ticketit';
    protected $fillable = array('subject', 'content', 'html', 'status_id', 'priority_id', 'user_id', 'agent_id', 'category_id', 'created_at', 'updated_at', 'completed_at');
    
    public function agent(){
        return $this->belongsTo('App\Models\User', 'agent_id', 'id'); 
    }

    public function creator(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id'); 
    }

    public function priority(){
       return $this->belongsTo('App\Models\Ticket\Priority', 'priority_id', 'id'); 
    }

    public function sub_categories(){
    	return $this->belongsTo('App\Models\Ticket\Category', 'category_id', 'id'); 
	}

    public function updates(){
    	return $this->hasMany('App\Models\Ticket\Update', 'ticket_id', 'id'); 
	}

    public function category(){
        return $this->belongsTo('App\Models\Department', 'category_id', 'id');
    }

    public function status(){
        return $this->belongsTo('App\Models\Ticket\Status', 'status_id', 'id');
    }

}
