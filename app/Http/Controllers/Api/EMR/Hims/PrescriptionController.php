<?php

namespace App\Http\Controllers\Api\EMR\Hims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Patient;
use App\Models\EMR\Drug;
use App\Models\EMR\DrugForm;
use App\Models\EMR\DrugRoute;
use App\Models\EMR\Frequency;
use App\Models\EMR\Prescription;
use App\Models\EMR\PrescriptionDrug;

class PrescriptionController extends Controller
{
    public function index()
    {
        //
    }

    public function initials()
    {
        return response()->json([
            'drug_forms' => DrugForm::orderBy('name', 'ASC')->get(),
            'drug_routes' => DrugRoute::orderBy('name', 'ASC')->get(),
            'frequencies' => Frequency::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id'        => 'required|numeric',
            'doctor_name'       => 'required|string',
            'doctor_id'         => 'required|numeric',
            'appointment_id'    => 'nullable|numeric',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $request->input('patient_id'),
            'appointment_id' => $request->input('appointment_id'), 
            'doctor_id' => $request->input('doctor_id'),
            'doctor_name' => $request->input('doctor_name'),
            'status' => $request->input('status') ?? 1,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);
        //dd($request->input('drugs'));
        foreach ($request->input('drugs') as $drug){
            PrescriptionDrug::create([
                'drug_id' => $drug['drug_id'],
                'drug_name' => $drug['drug_name'],
                'detail' => $drug['detail'],
                'dose' => $drug['dose'],
                'duration' => $drug['duration'],
                'form' => $drug['form'],
                'frequency' => $drug['frequency'],
                'route' => $drug['route'],
                'quantity' => $drug['quantity'],
                'prescription_id' => $prescription->id,
                'start_date' => date('Y-m-d'),
            ]);
        }
    }

    public function show($id)
    {
        return response()->json([
            'prescriptions' => Prescription::where('patient_id', '=', $id)->with('drugs')->latest()->paginate(10),
        ]);
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
