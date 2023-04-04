<?php

namespace App\Http\Controllers\Api\EMR\Hims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Vital;


class VitalController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id'        => 'required|numeric',
            'doctor_name'       => 'required|string',
            'doctor_id'         => 'required|numeric',
            'appointment_id'    => 'nullable|numeric',
        ]);

        $vital = Vital::create([
            'patient_id' => $request->input('patient_id'),
            'appointment_id' => $request->input('appointment_id') ?? NULL, 
            //'doctor_id' => $request->input('doctor_id'),
            //'doctor_name' => $request->input('doctor_name'),
            'taken_by' => $request->input('taken_by'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);
        
    }

    public function show($id)
    {
        return response()->json([
            'vitals' => Vital::where('patient_id', '=', $id)->latest()->paginate(10),
        ]);
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
