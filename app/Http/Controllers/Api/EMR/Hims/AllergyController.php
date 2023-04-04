<?php

namespace App\Http\Controllers\Api\EMR\Hims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\PatientAllergy;
use App\Models\EMR\Patient;

class AllergyController extends Controller
{
    public function initials()
    {
        
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //Validate the request
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'allergy_type_id' => 'required|numeric',
            'allergy'=> 'required|string',
            'description'=> 'nullable|string',
        ]);

        //Create a new Patient Allergy
        $patient_allergy = PatientAllergy::create([
            'patient_id' => $request->input('patient_id'),
            'allergy_type_id' => $request->input('allergy_type_id'),
            'allergy' => $request->input('allergy'),
            'description' => $request->input('description'),
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'patient' => Patient::where('id', '=', $patient_allergy->patient_id)->first(),
            'message' => 'Allergy created successfully',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'allergies' => PatientAllergy::where('patient_id', '=', $id)->paginate(3),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'allergy_type_id' => 'required|numeric',
            'allergy'=> 'required|string',
            'description'=> 'nullable|string',
        ]);

        //Create a new Patient Allergy
        $patient_allergy = PatientAllergy::find($id);
        $patient_id = $patient_allergy->patient_id;

        $patient_allergy->patient_id = $request->input('patient_id');
        $patient_allergy->allergy_type_id = $request->input('allergy_type_id');
        $patient_allergy->allergy = $request->input('allergy');
        $patient_allergy->description = $request->input('description');
        $patient_allergy->updated_by = auth('api')->id();

        $patient_allergy->save();

        return response()->json([
            'patient' => Patient::where('id', '=', $patient_id)->first(),
            'message' => 'Allergy created successfully',
        ]);
    }

    public function destroy($id)
    {
        $patient_allergy = PatientAllergy::find($id);
        $patient_id = $patient_allergy->patient_id;
        $patient_allergy->updated_by = auth('api')->id();
        $patient_allergy->deleted_by = auth('api')->id();
        $patient_allergy->deleted_at = date('Y-m-d H:i:s');
        $patient_allergy->save();

        return response()->json([
            'allergies' => PatientAllergy::where('patient_id', '=', $patient_id)->paginate(3),
            'message' => 'Allergy created successfully',
            'patient' => Patient::where('id', '=', $patient_id)->first(),  
        ]);
    }
}
