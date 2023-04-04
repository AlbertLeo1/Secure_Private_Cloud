<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NextOfKin;

class NOKController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'relationship' => 'required',
            'email' => 'sometimes|email',
            'address' => 'required',
        ]);

        $nok = NextOfKin::updateOrCreate(['user_id' => auth('api')->id()],
            ['relationship' => $request['relationship'],
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'address' => $request['address'],
            //'user_id' => auth('api')->id(),
            ]
        );
        return response()->json(['message' => 'Next of Kin updated']);

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
