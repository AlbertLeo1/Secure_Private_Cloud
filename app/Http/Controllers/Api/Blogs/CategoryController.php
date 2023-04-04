<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog\Category as BlogCategory;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'blog_categories' => BlogCategory::orderBy('name', 'ASC')->get(),
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
