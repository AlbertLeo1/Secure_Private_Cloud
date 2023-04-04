<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::whereNotIn('status', [6, 7, 8, 9])->with(['service', 'patient'])->orderBy('preferred_date', 'DESC')->paginate(10),
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(), 
            //'nations' => Country::orderBy('name', 'ASC')->get(),      
        ]);
    }

    public function initials()
    {
        return response()->json([
            'applicants'    => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments'  => Appointment::where('user_id', auth('api')->id())->with( 'patient', 'doctor', 'mo')->orderBy('preferred_date', 'ASC')->paginate(10),
            'areas'         => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'states'        => State::orderBy('name', 'ASC')->get(), 
            //'nations' => Country::orderBy('name', 'ASC')->get(),         
        ]);
    }

    public function store(Request $request)
    {
    
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.patient.nationality', 'payment' ])->first(),
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
