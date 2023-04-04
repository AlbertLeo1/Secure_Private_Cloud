<?php

namespace App\Http\Controllers\Api\EMR\Domiciliary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\ShiftType;


class ShiftTypeController extends Controller
{
    public function index()
    {
        return response()->json([
            'shift_types' => ShiftType::orderBy('name', 'ASC')->paginate(10), 
        ]);
    }

    public function store(Request $request)
    {
        $shift_types = ShiftType::create([
            'name' => $request->input('name'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'created_by' => auth('api')->id(),
        ]); 
        return response()->json([
            'shift_types' => ShiftType::orderBy('name', 'ASC')->paginate(10), 
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //$shift_type = ShiftType::where('id', '=', $id)->first();
        $shift_type = ShiftType::findOrFail($id);

        $shift_type->name = $request->input('name');
        $shift_type->start_time = $request->input('start_time');
        $shift_type->end_time = $request->input('end_time');
        $shift_type->status = $request->input('status');
        $shift_type->description = $request->input('description');
        $shift_type->updated_by = auth('api')->id();

        $shift_type->save();

        return response()->json([
            'shift_types' => ShiftType::orderBy('name', 'ASC')->paginate(3), 
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
