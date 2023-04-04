<?php

namespace App\Http\Controllers\Api\EMR\Domiciliary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Country;

use App\Models\EMR\Domiciliary;
use App\Models\EMR\Patient;
use App\Models\EMR\PatientTask;

use App\Models\HRMS\Employee;

class RequestController extends Controller
{
    public function assign(Request $request, $id)
    {
        $this->validate($request, [
            'staff_id' => 'required|numeric',
        ]);

        $domiciliary = Domiciliary::findOrFail($id);
        
        $domiciliary->assessed_by = $request->input('staff_id');
        $domiciliary->updated_by = auth('api')->id();

        $domiciliary->save();

        return response()->json([
            'domiciliaries' => Domiciliary::orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality',])->paginate(30), 
            'nations' => Country::select('id', 'name')->orderBy('name', 'ASC')->get(), 
            'patients' => Patient::select('id', 'first_name', 'middle_name', 'last_name')->orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }

    public function confirm(Request $request, $id)
    {

        $domiciliary = Domiciliary::findOrFail($id);

        $staff = Employee::where('user_id', '=', auth('api')->id())->first();
        
        //$domiciliary->assessed_by = auth('api')->id();
        $domiciliary->updated_by = auth('api')->id();
        $domiciliary->status = 1;
        $domiciliary->active = 1;

        $domiciliary->save();

        $activity = Activity::create([
            'activity_type_id' => 4,
            'user_id' => auth('api')->id(),
            'details' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' confirmed the Request of a patient',
            'ref_id'  => $id,
        ]);

        return response()->json([
            'domiciliaries' => Domiciliary::where('status', '<', 1)->orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality',])->paginate(30), 
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }

    public function index()
    {
        return response()->json([
            'domiciliaries' => Domiciliary::where('status', '>=', 1)->where('status', '<=', 5)->orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality', 'tasks'])->paginate(20), 
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::select('id', 'last_name', 'first_name', 'middle_name')->orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }

    public function pending()
    {
        return response()->json([
            'domiciliaries' => Domiciliary::where('status', '<', 1)->orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality',])->paginate(30), 
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            //'start_date' => 'required|date',
            'payment_type' => 'required',
            'hca_daily' => 'sometimes|numeric',
            'bsc_daily' => 'sometimes|numeric',
            'rn_daily' => 'sometimes|numeric',
        ]);

        $existing = Domiciliary::where('patient_id', '=', $request->input('patient_id'))->count();
        echo ($existing);
        if ($existing != 0){
            return response()->json([
                'message' => 'Patient already has an existing Domiciliary service, kindly update',
                'domiciliaries' => Domiciliary::orderBy('start_date', 'ASC')->with(['assessment', 'patient.nationality',])->paginate(30), 
                'nations' => Country::orderBy('name', 'ASC')->get(), 
                'patients' => Patient::orderBy('last_name', 'ASC')->get(),
            ]);
        }

        $domiciliary = Domiciliary::create([
            'patient_id' => $request->input('patient_id'), 
            'payment_type' => $request->input('payment_type'), 
            'start_date' => $request->input('start_date'), 
            'end_date' => $request->input('end_date') ?? NULL, 
            'status' => $request->input('status') ?? 0, 
            'active' => $request->input('active') ?? 0, 
            'hca_daily' => $request->input('hca_daily') ?? 0, 
            'rn_daily' => $request->input('rn_daily') ?? 0, 
            'bsc_daily' => $request->input('bsc_daily') ?? 0, 
            'requested_by' => auth('api')->id(), 
        ]);

        return response()->json([
            'domiciliaries' => Domiciliary::where('status', '>=', 1)->where('status', '<=', 5)->orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality',])->paginate(2), 
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::select('id', 'last_name', 'first_name', 'middle_name')->orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }

    public function show($id)
    {
        $domiciliary = Domiciliary::where('id', '=', $id)->with(['assessment', 'patient.nationality', 'tasks.frequency'])->first();
        $patient = Patient::where('id', '=', $domiciliary->patient_id)->with(['user', 'allergies', 'contacts'])->first();
        $patient_tasks = PatientTask::where('patient_id', '=', $domiciliary->patient_id)->with(['task', 'frequency'])->get(); 
        return response()->json([
            'domiciliary' => $domiciliary,
            'patient' =>  $patient,
            'patient_tasks' =>  $patient_tasks,
            'nations' => Country::orderBy('name', 'ASC')->get(), 
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'patient_id' => 'required|numeric',
            'start_date' => 'required|date',
            'payment_type' => 'required',
            'hca_daily' => 'sometimes|numeric',
            'bsc_daily' => 'sometimes|numeric',
            'rn_daily' => 'sometimes|numeric',
        ]);

        $domiciliary = Domiciliary::findOrFail($id);

        $domiciliary->patient_id = $request->input('patient_id');
        $domiciliary->payment_type = $request->input('payment_type');
        $domiciliary->start_date = $request->input('start_date');
        $domiciliary->end_date = $request->input('end_date') ?? NULL;
        $domiciliary->status = $request->input('status') ?? 0;
        $domiciliary->active = $request->input('active') ?? 0;
        $domiciliary->hca_daily = $request->input('hca_daily') ?? 0;
        $domiciliary->rn_daily = $request->input('rn_daily') ?? 0;
        $domiciliary->bsc_daily = $request->input('bsc_daily') ?? 0;
        $domiciliary->requested_by = auth('api')->id();

        $domiciliary->save();

        return response()->json([
            'domiliciaries' => Domiciliary::orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality',])->paginate(30), 
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }

    public function destroy($id)
    {

        $domiciliary = Domiciliary::findOrFail($id);

        $domiciliary->deleted_by = auth('api')->id();
        $domiciliary->deleted_at = date('Y-m-d H:i:s');
        $domiciliary->save();

        $activity = Activity::create([
            'activity_type_id' => 3,
            'user_id' => auth('api')->id(),
            'details' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' deleted the Request of a patient',
            'ref_id'  => $id,
        ]);

        return response()->json([
            'domiciliaries' => Domiciliary::where('status', '<', 1)->orderBy('start_date', 'DESC')->with(['assessor.user', 'assessment', 'patient.nationality',])->paginate(30), 
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get(),
            'employees' => Employee::orderBy('unique_id', 'ASC')->with(['user', 'qualification'])->get(), 
        ]);
    }
}