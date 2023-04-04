<?php

namespace App\Http\Controllers\Api\Ticketing;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

use App\Models\Ticket\Status;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Update;
use App\Models\User;


class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $ticket = Ticket::find($request->input('ticket_id'));
        // Status 1: New, 2 - Department Accept, 3 - Assigned, 4 - Department Replied, 5 - Customer Replied, 6 - Closed
        switch ($request->input('type_id')){
            case 1:
                $subject = " opened a new ticket";
                break;
            case 2:
                $subject = " accepted the ticket";
                break;
            case 3:
                if ($request->input('user_id')!= ''){
                    $user = User::find($request->input('user_id'));
                    $subject = " reassigned the ticket to ".$user->first_name.' '.$user->last_name;
                    $ticket->agent_id = $request->input('user_id');
                    $ticket->category_id = $request->input('dept_id');
                }
                else {
                    $department = Department::find($request->input('dept_id'));
                    $subject = " reassigned the ticket to new department: ".$department->name;
                }
                break;

            case 4:
                $subject = " updated the ticket ";
                break;
            case 5:
                $subject = " updated the ticket ";
                break;
            case 6:
                $subject = " closed the ticket";
                break;

            default:
                $subject = " updated ticket";
                break;
        }
        
        $ticket->status_id = $request->input('status_id');
        $ticket->save();

        if ((is_null($ticket->agent_id)) && ($request->input('status_id') == 4) && (auth('api')->user()->department_id == $ticket->category_id)){
            $update = Update::create([
                'subject' => " accepted the ticket", 
                'ticket_id' => $request->input('ticket_id'), 
                'status_id' => 2, 
                'type_id' => $request->input('type_id') ?? 3, 
                'user_id' => auth('api')->id(), 
                'content' => auth('api')->user()->first_name." ".auth('api')->user()->last_name." accepted the ticket on behalf of department",    
            ]);
        }
        $update = Update::create([
            'subject' => $subject ?? 'Updated', 
            'ticket_id' => $request->input('ticket_id'), 
            'status_id' => $request->input('status_id'), 
            'type_id' => $request->input('type_id') ?? 3, 
            'user_id' => auth('api')->id(), 
            'content' => $request->input('content') ?? 'Not Required', 
        ]);

        return response()->json([
            'message' => 'Successful',
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        // Status 1: New, 2 - Department Accept, 3 - Assigned, 4 - Department Replied, 5 - Customer Replied, 6 - Closed
        switch ($request->input('type_id')){
            case 1:
                $subject = " opened a new ticket";
                break;
            case 2:
                $subject = " accepted the ticket";
                break;
            case 3:
                $subject = " reassigned the ticket to ";
                
                break;

            case 4:
                $subject = " updated the ticket ";
                break;
            case 5:
                $subject = " updated the ticket ";
                break;
            case 6:
                $subject = " closed the ticket";
                break;

            default:
                $subject = " updated ticket";
                break;
        }
        
        
        $update = Update::create([
            'subject' => $subject ?? 'Updated', 
            'ticket_id' => $request->input('ticket_id'), 
            'status_id' => $request->input('status_id'), 
            'type_id' => $request->input('type_id'), 
            'user_id' => auth('api')->id(), 
            'content' => $request->input('comment'), 
        ]);

        return response()->json([
            'statuses' => Status::whereNotIn('id', [1, 2, 3])->orderBy('name', 'ASC')->get(),
            'ticket'    => Ticket::where('id', '=', $request->input('ticket_id'))->with('category.hod')->with('priority')->with('creator')->with('agent')->first(), 
            'updates'  => Update::where('ticket_id', '=', $request->input('ticket_id'))->with('stat')->with('user')->get(),             
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
