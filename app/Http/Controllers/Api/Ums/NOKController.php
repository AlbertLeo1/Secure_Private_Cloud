<?php

namespace App\Http\Controllers\Api\Ums;

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
            ]
        );
        return response()->json(['message' => 'Next of Kin updated']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
