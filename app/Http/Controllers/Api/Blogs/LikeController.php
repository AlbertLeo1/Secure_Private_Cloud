<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use App\Models\Blog\Like;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function likeorUnlike($id)
    {
        $post = Post::find($id);
        
        if(!$post){return response(['message' => 'Post not found'], 403);}
        
        $like = $post->likes()->where('user_id', auth('api')->id())->withTrashed()->first();

        if(!$like){
            Like::create([
                'user_id' => auth('api')->id(),
                'post_id' => $id,
            ]);

            return response(['message' => 'Liked']);
        }
        else if ($like->deleted_at != null){
            $like->update([
                'deleted_at' => null,
                'deleted_by' => null,
            ]);
            return response(['message' => 'Liked'],);
        }
        else{
            $like->update([
                'deleted_by' => auth('api')->id()
            ]);
            $like->delete();
            return response(['message' => 'Unliked'],);
        }
        
    }
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
