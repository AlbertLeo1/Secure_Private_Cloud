<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'blog_categories';
    protected $fillable = array('name', 'description', 'created_by', 'created_at', 'deleted_by'); 

    public function approved(){
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function author(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Blog\Category', 'room_id', 'id');
    }

    public function tags(){
        return $this->hasMany('App\Models\Blog\PostTag', 'post_id', 'id');
    }

}
