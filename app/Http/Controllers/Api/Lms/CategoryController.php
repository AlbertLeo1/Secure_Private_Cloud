<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();
        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|numeric',
            'name' => 'required|unique:course_categories',
            'description' => 'sometimes|string',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
        ]);

        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();
        return response()->json(['categories' => $categories]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //Validate Request
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'description' => 'sometimes',
        ]);

        //Update the Category
        $category = Category::find($id);
        
        $category->name = $request['name'];
        $category->status = $request['status'];
        $category->description = $request['description'];

        $category->save();

        //Return Categories
        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();
        return response()->json(['categories' => $categories]);
    }

    public function destroy($id)
    {
        //
        $category = Category::find($id);

        $category->delete();

        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();

        return response()->json([
            'categories' => $categories,
            'message' => 'Category '.$category->name.' has been deleted',
        ]);
    }
}
