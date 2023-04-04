<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Like extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'blog_post_likes';
    protected $fillable = array('post_id', 'user_id', 'deleted_at', 'deleted_by'); 

    public function approved(){
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
