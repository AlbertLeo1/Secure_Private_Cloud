<?php

namespace App\Http\Controllers\Api\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket\Ticket;

class PriorityController extends Controller
{
    public function index()
    {
        //
    }
    
    public function mine()
    {
        return response()->json([
            'created_tickets' => Ticket::where('created_by', )
        ]);
    }

    public function store(Request $request)
    {
        //
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
