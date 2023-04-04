<?php

namespace App\Http\Controllers\Api\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;

use App\Models\Ticket\Status;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Priority;
use App\Models\Ticket\Update;

class TicketController extends Controller
{
    public function departmental()
    {
        $dept_tickets = Ticket::where('category_id', '=', auth('api')->user()->department_id)->with('category')->with(['priority','creator', 'agent', 'status'])->paginate(10);
        
        return response()->json([
            'dept_tickets'    => $dept_tickets,              
            'priorities'      => Priority::all(),
            'categories'      => Department::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function index()
    {
        
    }

    public function initials()
    {
        return response()->json([
            'categories'      => Department::orderBy('name', 'ASC')->get(),
            'priorities'      => Priority ::all(),             
        ]);
    }

    public function personal()
    {
        $by_tickets = Ticket::where('user_id', '=', auth('api')->id())->with(['category', 'priority', 'creator', 'agent', 'status'])->orderBy('status_id', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $my_tickets = Ticket::where('agent_id', '=', auth('api')->id())->with(['category', 'priority', 'creator', 'agent','status'])->paginate(10);

        return response()->json([
            'by_tickets'      => $by_tickets,              
            'my_tickets'      => $my_tickets,              
            'priorities'      => Priority::all(),
            'categories'      => Department::orderBy('name', 'ASC')->get(),
        ]);
    }
    
    public function show($id)
    {
        return response()->json([
            'statuses' => Status::whereNotIn('id', [1, 2, 3])->orderBy('name', 'ASC')->get(),
            'ticket'    => Ticket::where('id', '=', $id)->with(['category.hod', 'priority', 'creator', 'agent', 'status'])->first(), 
            'updates'  => Update::where('ticket_id', '=', $id)->with(['stat', 'user'])->get(),             
        ]);
    }

    public function store(Request $request)
    {
        $ticket = Ticket::create([
            'subject' => $request->input('subject'), 
            'content' => $request->input('content'), 
            'status_id' => 1, 
            'priority_id'  => $request->input('priority_id'), 
            'user_id' => auth('api')->id(), 
            'agent_id' => null, 
            'category_id' => $request->input('category_id'), 
        ]);

        $update = Update::create([
            'subject' => 'Opened a new ticket', 
            'ticket_id' => $ticket->id, 
            'status_id' => 1, 
            'type_id' => 1, 
            'user_id' => auth('api')->id(), 
            'content' => $request->input('content'), 
        ]);

        $by_tickets = Ticket::where('user_id', '=', auth('api')->id())->with('category')->with('priority')->with('creator')->with('agent')->paginate(10);
        $my_tickets = Ticket::where('agent_id', '=', auth('api')->id())->with('category')->with('priority')->with('creator')->with('agent')->paginate(10);

        return response()->json([
            'by_tickets'      => $by_tickets,              
            'my_tickets'      => $my_tickets,              
            'priorities'      => Priority::all(),
            'categories'      => Department::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        $update = Update::create([
            'subject' => ' closed this ticket', 
            'ticket_id' => $id, 
            'status_id' => 6, 
            'type_id' => 3, 
            'user_id' => auth('api')->id(), 
            'content' => 'Closed this ticket', 
        ]);

        $ticket->status_id = 6;
        $ticket->save();

        return response()->json([
            'by_tickets' => Ticket::where('user_id', '=', auth('api')->id())->with('category')->with('priority')->with('creator')->with('agent')->paginate(10),
            'my_tickets' => Ticket::where('agent_id', '=', auth('api')->id())->with('category')->with('priority')->with('creator')->with('agent')->paginate(10),
            'dept_tickets' => Ticket::where('category_id', '=', auth('api')->user()->department_id)->with('category')->with(['priority','creator', 'agent', 'status'])->paginate(10), 
            'statuses' => Status::whereNotIn('id', [1, 2, 3])->orderBy('name', 'ASC')->get(),
            'ticket'    => Ticket::where('id', '=', $id)->with(['category.hod', 'priority', 'creator', 'agent', 'status'])->first(), 
            'updates'  => Update::where('ticket_id', '=', $id)->with(['stat', 'user'])->get(),             
        ]);
    }
}
