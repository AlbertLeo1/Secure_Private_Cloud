<?php

namespace App\Http\Controllers\Api\EMR\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Assessment\HealthSubstance;

class HealthSubstanceController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'domiciliary_id' => 'nullable|numeric',
            'product_name' => 'required',
            'harm_type' => 'required',
            'substance_form' => 'required',
            'substance_colour' => 'required',
            'causes_harm' => 'string',
            'contact' => 'required|string',
            'frequency' => 'sometimes|nullable|string',
        ]);

        $health_substance = HealthSubstance::create([
            'patient_id' => $request->input('patient_id'), 
            'domiciliary_id' => $request->input('domiciliary_id'), 
            'product_name' => $request->input('product_name'), 
            'harm_type' => $request->input('harm_type'), 
            'substance_form' => $request->input('substance_form'), 
            'substance_colour' => $request->input('substance_colour'), 
            'causes_harm' => $request->input('causes_harm'), 
            'contact' => $request->input('contact'), 
            'frequency' => $request->input('frequency'), 
            'substance_use' => $request->input('substance_use'), 
            'safer_alternative' => $request->input('safer_alternative'), 
            'controls' => $request->input('controls'), 
            'emergency_procedure' => $request->input('emergency_procedure'), 
            'staff_aware' => $request->input('staff_aware'), 
            'reduced_risk' => $request->input('reduced_risk'), 
            'further_actions' => $request->input('further_actions'),
            'created_by' => auth('api')->id(),
            'created_at' => date('Y-m-d H:i:s'), 
            'updated_by' => auth('api')->id(),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'health_substance' => $health_substance,
        ]);


    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $health_substance = HealthSubstance::find($id);
        $health_substance->patient_id = $request->input('patient_id'); 
        $health_substance->domiciliary_id = $request->input('domiciliary_id'); 
        $health_substance->product_name = $request->input('product_name'); 
        $health_substance->harm_type = $request->input('harm_type'); 
        $health_substance->substance_form = $request->input('substance_form'); 
        $health_substance->substance_colour = $request->input('substance_colour'); 
        $health_substance->causes_harm = $request->input('causes_harm'); 
        $health_substance->contact = $request->input('contact'); 
        $health_substance->frequency = $request->input('frequency'); 
        $health_substance->substance_use = $request->input('substance_use'); 
        $health_substance->safer_alternative = $request->input('safer_alternative'); 
        $health_substance->controls = $request->input('controls'); 
        $health_substance->emergency_procedure = $request->input('emergency_procedure'); 
        $health_substance->staff_aware = $request->input('staff_aware'); 
        $health_substance->reduced_risk = $request->input('reduced_risk'); 
        $health_substance->further_actions = $request->input('further_actions'); 
        $health_substance->updated_by = auth('api')->id();
        $health_substance->updated_at =date('Y-m-d H:i:s');

        $health_substance->save();

        return response()->json([
            'health_substance' => $health_substance,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
