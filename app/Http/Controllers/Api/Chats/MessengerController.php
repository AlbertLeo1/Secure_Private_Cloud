<?php

namespace App\Http\Controllers\Api\Chats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Chats\Room;
use App\Models\Chats\Member;
use App\Models\Chats\Message;

class MessengerController extends Controller
{
    public function add(Request $request)
    {
        //Do a basic check
        $this->validate($request, [
            'chat_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'content'=> 'required',
        ]);

        //Add Message to Database 
        $message = Message::create([
            'user_id' => $request->input('user_id'), 
            'room_id' => $request->input('chat_id'), 
            'content' => $request->input('content_id'), 
        ]);

        //Touch the Room to Update status
        $chat = Room::find($request->input('chat_id'));
        $chat->touch();

        //Send response
        return response()->json([
            'chat' => $chat,       
        ]);

    }

    public function private(){
        $membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        $chats = Room::whereIn('id', $membership)->with('messages.user')->with('members.user')->orderBy('updated_at', 'DESC')->paginate(10);

        return response()->json([
            'chats' => $chats, 
            'user'  => auth('api')->user(),     
        ]);
    }
    
    public function rooms(){
        $membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        $chats = Room::where('room_type', '=', 'Group')->whereIn('id', $membership)->with('messages')->orderBy('updated_at', 'DESC')->get();

        return response()->json([
            'chats' => $chats,       
        ]);
    }
    
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $message = Message::create([
            'user_id'       => $request->input('user_id'),
            'room_id'       => $request->input('chat_id'),
            'content'       => $request->input('content'),
        ]);

        $membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        $chats = Room::whereIn('id', $membership)->with('messages.user')->with('members.user')->orderBy('updated_at', 'DESC')->paginate(10);
        $chat = Room::where('id', '=', $request->input('chat_id'))->with('messages.user')->with('members.user')->orderBy('updated_at', 'DESC')->first();
        $chat->touch();
        
        return response()->json([
            'chat'  => $chat,       
            'chats' => $chats,       
        ]);

    }

    public function show($id)
    {
        //Check that User is still a member of the group
        $member = Member::where('room_id', '=', $id)->where('user_id', '=', auth('api')->id())->count();
        if ($member == 0){return response()->json(['chat'  => '', 'nogo' => 'Not Member of this Group']);}

        //Get all the messages included in this chat
        $chat = Room::where('id', '=', $id)->with('messages.user')->with('members.user')->orderBy('updated_at', 'DESC')->first();
        
        //Return Values
        return response()->json(['chat'  => $chat,]);
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
