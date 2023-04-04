<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Branch;
use App\Models\NextOfKin;
use App\Models\Staff;
use App\Models\State;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'user' => Staff::where('user_id', auth('api')->id())->with('area')->with('branch')->with('state')->with('next_of_kin')->get(),
            'areas' => Area::select('name', 'id')->where('state_id', 25)->get(),
            'branches' => Branch::all(),
            'states' => State::where('country_id', 1)->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'sometimes|numeric',
            'branch_id' => 'required|numeric',
            'sex' => 'required|string',
            'email' => 'required|unique:users',
            'dob' => 'required|date',
        ]);

        $user = User::updateOrCreate(['email' => $request['email']],
            ['first_name' => $request['first_name'],
            'other_name' => $request['other_name'],
            'last_name' => $request['last_name'],
            'street' => $request['street'],
            'street2' => $request['street2'],
            'city' => $request['city'],
            'state_id' => $request['state_id'],
            'area_id' => $request['area_id'],
            'phone' => $request['phone'],
            'alt_phone' => $request['alt_phone'],
            'branch_id' => $request['branch_id'],
            'sex' => $request['sex'],
            'dob' => $request['dob'],
            'image' => $request['image'],
            ]
        );

        return response()->json([
            'user' => User::where('id', auth('api')->id())->with('area')->with('branch')->with('state')->with('next_of_kin')->with('fullname')->get(),
            'areas' => Area::select('name', 'id')->where('state_id', 25)->get(),
            'branches' => Branch::all(),
            'states' => State::where('country_id', 1)->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            ]);
    }

    public function show($id)
    {
        //
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
