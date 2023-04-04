<?php

namespace App\Http\Controllers\Api\Chats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Chats\Room;
use App\Models\Chats\Member;
use App\Models\Chats\Message;

class RoomController extends Controller
{
    public function index()
    {
        //Get A List of Rooms where Logged In User is a Member and the Room is still active
        $membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        $lists = Room::whereIn('id', $membership)->with('messages')->get();

        return response()->json([
            'lists' => $lists,       
        ]);
    }

    public function store(Request $request)
    {
        //First Validate the Entry

        //Next, confirm that User is still a Member of this group
        $room = Room::create([
            'created_by' => auth('api')->id(),
            'name'       => $request->input('name'),
            'room_type'  => 'Private',
        ]);

        //$membership = Member::where('room_id', '=', $request->input('room_id'));
        //Send Confirmation
        
        //Create members of the group
        Member::create([
            'room_id'       => $room->id,
            'user_id'       => auth('api')->id(),
            'requested_by'  => auth('api')->id(),
            'status'        => 1,
        ]);

        //$room_members = Member::select('user_id')->where('room_id', '=', $room->id)->get();

        foreach ($request->input('members') as $member){
            /*if(!in_array($member, $room_members)){ }*/
            if ($member != auth('api')->id()){
                Member::create([
                    'room_id'       => $room->id,
                    'user_id'       => $member,
                    'requested_by'  => auth('api')->id(),
                    'status'        => 1,
                ]);
            }
        }

        $membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        $chats = Room::whereIn('id', $membership)->with('messages')->with('members.user')->orderBy('updated_at', 'DESC')->paginate(10);

        return response()->json([
            'chats' => $chats,
            'chat'  => $room       
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

    public function check($id)
    {
        $my_rooms = Member::select('room_id')->where('user_id', '=', auth('api')->id())->distinct()->get();
        $partner_room = Member::select('room_id')->where('user_id', '=', $id)->WhereIn('room_id', $my_rooms)->get();
        $rooms = Room::whereIn('id', $partner_room)->with('members')->get();
        $private_room = array();

        if (count($rooms) == 0){
            $room = Room::create(['created_by' => auth('api')->id(), 'name'=>'Private Conversation', 'room_type'  => 'Private',]);
    
            Member::create(['room_id'=>$room->id, 'user_id'=>auth('api')->id(), 'requested_by'=>auth('api')->id(), 'status'=> 1,]);
            Member::create(['room_id'=>$room->id, 'user_id'=>$id, 'requested_by'=>auth('api')->id(), 'status'=> 1,]);
        }
        else{
            foreach ($rooms as $room){
                if (count($room->members) == 2){ 
                    if (empty($private_room)){
                        $private_room = $room;
                        $room->touch();
                    }
                    else {
                        Message::where('room_id', '=', $room->id)->update(['room_id' => $private_room]);
                        $del_room = Room::where('id', '=', $room->id)->first();
                        $del_room->delete();
                    }
                }
            }
            if (empty($private_room)){
                $room = Room::create(['created_by' => auth('api')->id(), 'name'=>'Private Conversation', 'room_type'  => 'Private',]);
    
                Member::create(['room_id'=>$room->id, 'user_id'=>auth('api')->id(), 'requested_by'=>auth('api')->id(), 'status'=> 1,]);
                Member::create(['room_id'=>$room->id, 'user_id'=>$id, 'requested_by'=>auth('api')->id(), 'status'=> 1,]);
            }
        }
        return response()->json([
            'my_rooms' => $my_rooms,
            'rooms' => $partner_room,
            'chat' => $room,
        ]);
    }
}
