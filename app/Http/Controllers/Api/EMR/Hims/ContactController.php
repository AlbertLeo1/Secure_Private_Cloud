<?php

namespace App\Http\Controllers\Api\EMR\Hims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\PatientContact; 

class ContactController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'name' => 'required|string',
            'address'=> 'required|string',
            'email_address'=> 'nullable|string',
            'phone'=> 'nullable|string',
        ]);

        $patient_contact = PatientContact::create([
            'patient_id' => $request->input('patient_id'),
            'name' => $request->input('name'),
            'address'=> $request->input('address'),
            'email_address'=> $request->input('email_address'),
            'phone'=> $request->input('phone'),
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'message' => "Contact created successfully",
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'contacts' => PatientContact::where('patient_id', '=', $id)->paginate(10),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'name' => 'required|string',
            'address'=> 'required|string',
            'email_address'=> 'nullable|string',
            'phone'=> 'nullable|string',
        ]);

        $patient_contact = PatientContact::find($id);
        $patient_contact->patient_id = $request->input('patient_id');
        $patient_contact->name = $request->input('name');
        $patient_contact->address = $request->input('address');
        $patient_contact->email_address = $request->input('email_address');
        $patient_contact->phone = $request->input('phone');
        $patient_contact->updated_by = auth('api')->id();
        
        $patient_contact->save();

        return response()->json([
            'message' => "Contact created successfully",
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
