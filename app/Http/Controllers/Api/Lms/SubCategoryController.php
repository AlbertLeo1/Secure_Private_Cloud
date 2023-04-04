<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Category;
use App\Models\Lms\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'status' => 'required',
            'description' => 'sometimes',
        ]);
        //Process
        $sub_category = SubCategory::create([
            'name' => $request['name'],
            'category_id' => $request['category_id'],
            'status' => $request['status'],
            'description' => $request['description'],
            ]);
        //Reponse
        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();

        return response()->json([
            'categories' => $categories,
            'message' => 'Sub Category '.$sub_category->name.' has been updated',
        ]);
    }
    public function show($id)
    {
        $sub_categories = SubCategory::where('category_id', '=', $id)->orderBy('name', 'ASC')->get();

        return response()->json([
            'sub_categories' => $sub_categories,
            ]);
    }

    public function update(Request $request, $id)
    {
        $sub_category = SubCategory::find($id);

        $sub_category->name = $request['name'];
        $sub_category->category_id = $request['category_id'];
        $sub_category->status = $request['status'];
        $sub_category->description = $request['description'];

        $sub_category->save();

        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();

        return response()->json([
            'categories' => $categories,
            'message' => 'Sub Category '.$sub_category->name.' has been updated',
        ]);

    }

    public function destroy($id)
    {
        $sub_category = SubCategory::find($id);

        $sub_category->delete();

        $categories = Category::orderBy('name', 'ASC')->with('sub_categories')->get();

        return response()->json([
            'categories' => $categories,
            'message' => 'Sub Category '.$sub_category->name.' has been deleted',
        ]);
    }
}
