<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use App\Models\EMR\Appointment;
use App\Models\EMR\Payment;
use App\Models\EMR\Service;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json([
            'payments' => Payment::with(['service', 'patient', 'appointment', 'employee'])->latest()->paginate(10),
            'unpaid_appointments' => Appointment::where('status', 0)->with(['service', 'patient'])->orderBy('date', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        //Validate the request
        $this->validate($request, [
            'service_id' => 'required|numeric',
            'patient_id' => 'required|numeric',
            'appointment_id' => 'required|numeric',
            'channel'=> 'required|string',
            'amount'=> 'required|numeric',
            'details' => 'nullable|string',
        ]);

        //Insert Payment
        $payment = Payment::create([
            'service_id' => $request->input('service_id'), 
            'patient_id' => $request->input('patient_id'), 
            'appointment_id' => $request->input('appointment_id'),
            'amount' => $request->input('amount'), 
            'employee_id' => $request->input('employee_id') ?? auth('api')->id(),
            'channel' => $request->input('channel'), 
            'details' => $request->input('details'),    
        ]);
        
        //Update the appointment with payment details
        $appointment = Appointment::find($request->input('appointment_id'));

        $appointment->status = 1;
        $appointment->payment_channel = $payment->channel;
        $appointment->paid_by = auth('api')->id();
        $appointment->save();
        
        //Return Values
        return response()->json([
            'payment' => Payment::where('id', $payment->id)->with(['service', 'patient'])->first(),
            'payments' => Payment::with(['service', 'patient'])->latest()->paginate(10),
            'appointments' => Appointment::whereNOTIN('status', [6, 7, 8, 9])->with(['service', 'patient'])->orderBy('date', 'ASC')->paginate(10),
            'appointment' => Appointment::where('id', $appointment->id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality' ])->first(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'payment' => Payment::where('id', $id)->with(['service', 'patient.state'])->first(),
            'payments' => Payment::with(['service', 'patient'])->latest()->paginate(10),
            'appointments' => Appointment::whereNOTIN('status', [6, 7, 8, 9])->with(['service', 'patient'])->orderBy('date', 'ASC')->paginate(10),
       ]);
    }

    public function update(Request $request, $id)
    {
        //
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
