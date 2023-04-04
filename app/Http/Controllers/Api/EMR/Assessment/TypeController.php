<?php

namespace App\Http\Controllers\Api\EMR\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Assessment\AssessmentType;
use App\Models\EMR\Assessment\TypeItem;
use App\Models\EMR\Assessment\Item;

class TypeController extends Controller
{
    public function index()
    {
        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->get(),
            'types' => AssessmentType::with(['assessments', 'creator'])->paginate(20), 
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'assessments' => 'required|array',
            'assessments.*' => 'required|numeric',
        ]);
        
        $type = AssessmentType::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        TypeItem::where('type_id', '=', $type->id)->delete();
        
        foreach ($request->input('assessments') as $assessment){
            TypeItem::create([
                'type_id' => $type->id,
                'item_id' => $assessment,
            ]);
        }

        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->get(),
            'types' => AssessmentType::with(['assessments', 'creator'])->paginate(20), 
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'assessments' => 'required|array',
            'assessments.*' => 'required|numeric',
        ]);

        $type = AssessmentType::findOrFail($id);

        $type->name = $request->input('name');
        $type->description = $request->input('description');
        $type->updated_by = auth('api')->id();
        
        $type->save();

        TypeItem::where('type_id', '=', $type->id)->delete();

        foreach ($request->input('assessments') as $assessment){
            TypeItem::create([
                'type_id' => $type->id,
                'item_id' => $assessment,
            ]);
        }

        return response()->json([
            'items' => Item::orderBy('name', 'ASC')->get(),
            'types' => AssessmentType::with(['assessments', 'creator'])->paginate(20), 
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
