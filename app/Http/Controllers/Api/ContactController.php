<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket\Message;
use App\Models\Ticket\Ticket;

class ContactController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'contact_type' => 'required',
            'message' => 'required',
        ]);

        $message = Message::create([
            'subject'       => $request->input('subject') ?? 'Test',
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'email'         => $request->input('email'),
            'phone'         => $request->input('phone'),
            'contact_type'  => $request->input('contact_type'),
            'message'       => $request->input('message'),
        ]);

        //Send a mail to the user thanking him for his message

        //Send a notification to the Staffs with category

        return response()->json([
            'message'       => 'All Done',
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
