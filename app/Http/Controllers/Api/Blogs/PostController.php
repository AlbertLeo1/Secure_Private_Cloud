<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Blog\Post;
use App\Models\Blog\Comment;
use App\Models\Blog\Category as BlogCategory;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['initials', 'index', 'show', ]);
    }

    
    public function index()
    {
        return response()->json([
            'blogs' => Post::with(['likes', 'author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(12),
        ], 200);
    }

    public function initials()
    {
        return response()->json([
            'blogs' => Post::with(['likes', 'author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(3),
            'blog_categories' => BlogCategory::orderBy('name', 'ASC')->get(),
            'recent_stories' => Post::with(['likes', 'author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->limit(4)->get(),
        ], 200);
    }

    public function mine()
    {
        return response()->json([
            'blogs' => Post::where('user_id', '=', auth('api')->id())->with(['likes', 'author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(12),
            'blog_categories' => BlogCategory::orderBy('name', 'ASC')->get(),
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'topic' => 'required|string|max:200',
            'category_id' => 'required|integer',
            'content'   => 'required|string',
        ]);

        $image = null;
        $type = null;

        $image = $this->saveImage($image, 'posts', 'png');

        $post = Post::create([
            'topic' => $request->input('topic') ?? 'Test Topic', 
            'image' => $image, 
            'content' => $request->input('content'), 
            'user_id' => auth('api')->id(), 
            'category_id' => $request->input('category_id'), 
            'status' => 0, 
            'approved_by' => null, 
            'approval_date' => null,
            'published_date' => null, 
        ]);

        return response()->json([
            'blogs' => Post::with(['author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(5),
        ], 200);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if(!$post){return response(['message' => 'Post not found'], 403);}
        
        $user = auth('api')->user() ?? null;
        
        return response()->json([
            'activities' => Activity::where('activity_type', 'Blog')->where('ref_id', $id)->with(['author'])->latest()->paginate(5),
            'blog' => Post::where('id', '=', $id)->with(['author', 'category', 'approved'])->withCount('comments', 'likes')
            ->first(),
            'comments' => Comment::where('post_id', '=', $id)->with('author')->latest()->paginate(5),
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'topic' => 'required|string|max:200',
            'category_id' => 'required|integer',
            'content'   => 'required|string',
        ]);
        
        $image = null;
        
        $post = Post::find($id);

        if(!$post){return response(['message' => 'Post not found'], 403);}
        if($post->user_id != auth('api')->id()){return response(['message' => 'Permission denied'], 403);}

        $post->topic = $request->input('topic'); 
        $post->image = $image; 
        $post->content = $request->input('content'); 
        $post->user_id = auth('api')->id(); 
        $post->category_id = $request->input('category_id'); 
        $post->status = 0; 
        $post->approved_by = null; 
        $post->published_date = null;

        $post->save();
        
        return response()->json([
            'post'  => $post,
            'blogs' => Post::with(['author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(5),
            'message' => 'Post Updated',
        ]);
    }

    public function destroy($id)
    {
        $image = null;
        
        $post = Post::find($id);

        if(!$post){return response(['message' => 'Post not found']);}
        if($post->user_id != auth('api')->id()){return response(['message' => 'Permission denied']);}
        
        $post->comments()->delete();
        $post->likes()->delete();
        $post->deleted_by = auth('api')->id();
        $post->deleted_at = date('Y-m-d H:i:s');
        $post->save();

        return response()->json([
            //'post'  => $post,
            'blogs' => Post::with(['author', 'category', 'approved'])->withCount('comments', 'likes')->latest()->paginate(5),
            'message' => 'Post Deleted',
        ]);

    }
}
