<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Models\Blog\PostTag;

class CommentController extends Controller
{
    public function index()
    {
        
    }

    public function initials($id)
    {
        $post = Post::find($id);
        
        if(!$post){return response(['message' => 'Post not found'], 403);}

        return response()->json([
            'post'  => $post->comments()->with('user:id, first_name, last_name, image')->get(),
            //'blogs' => Post::with(['author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(5),
            'message' => 'Post Updated',
        ]);
        
    }

    public function store(Request $request)
    {
        //
    }

    public function stored(Request $request, $id)
    {
        $this->validate($request, [
            'content'   => 'required|string',
        ]);

        $post = Post::find($id);
        if(!$post){return response(['message' => 'Post not found'], 403);}

        $comment = Comment::create([
            'message' => $request->input('content'),
            'post_id' => $id,
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'post'  => $post->comments()->with('author:id,first_name,last_name,image')->get(),
            //'blogs' => Post::with(['author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(5),
            'message' => 'Comment Created',
        ]);
    }

    public function show($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if(!$comment){return response(['message' => 'Post not found'], 403);}
        if($comment->user_id != auth('api')->id()){return response(['message' => 'Permission denied'], 403);}

        $this->validate($request, ['content'   => 'required|string',]);

        $comment->update([
            'message' => $request->input('content')
        ]);

        $post = Post::find($comment->post_id);
        return response()->json([
            'post'  => $post->comments()->with('user:id, first_name, last_name, image')->get(),
            //'blogs' => Post::with(['author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(5),
            'message' => 'Comment Created',
        ]);


    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if(!$comment){return response(['message' => 'Post not found'], 403);}
        if($comment->user_id != auth('api')->id()){return response(['message' => 'Permission denied'], 403);}

        $comment->delete();

        return response([
            'message' => 'Comment Deleted'
        ]);
    }
}
