<?php

namespace App\Models\Blog;

//use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;
class Post extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'blog_posts';
    protected $fillable = array('topic', 'image', 'user_id', 'content', 'category_id', 'status', 'approved_by', 'published_date', 'created_at', 'updated_at', 'deleted_at', 'deleted_by'); 

    public function approved(){
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function author(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Blog\Category', 'category_id', 'id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Blog\Comment', 'post_id', 'id');
    }

    public function likes(){
        return $this->hasMany('App\Models\Blog\Like', 'post_id', 'id');
    }

    public function tags(){
        return $this->hasMany('App\Models\Blog\PostTag', 'post_id', 'id');
    }

}
