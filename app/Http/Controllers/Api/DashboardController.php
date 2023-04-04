<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chats\Member;
use App\Models\Chats\Room;
//use App\Models\Chats\Message;
use App\Models\SOM\Month;
use App\Models\SOM\Winner;
use App\Models\Activity;
use App\Models\Notice;
use App\Models\User;
use App\Models\Staff;
use App\Models\Blog\Post as BlogPost;
use App\Models\EMR\Doctor;
use App\Models\EMR\Hospital;
use App\Models\EMR\Agency;
use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
//use Kordy\Ticketit\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        $chats = Room::whereIn('id', $membership)->with('messages.user')->with('members.user')->orderBy('updated_at', 'DESC')->paginate(10);
        $activities = Activity::where('user_id', '=', auth('api')->id())->with('author')->latest()->get();
        //$staff_month = $this->staff_months('1');
        
        return response()->json([
            //'birthdays'     => User::birthDayBetween(Carbon::now(), Carbon::now()->addWeek())->orderByRaw("DAYOFMONTH('dob')", 'ASC')->limit(8)->get(),
            'activities'    => $activities,
            'chats'         => $chats,
            'message_rooms' => Member::where('user_id', '=', auth('api')->id())->with('room.messages')->get(),
            //'new_staffs'    => User::orderBy('created_at', 'DESC')->limit(8)->get(),
            //'tickets'       => Ticket::where('agent_id', '=', auth('api')->id())->orWhere('category_id', '=', auth('api')->user()->department_id)->with(['creator', 'category', 'status', 'priority'])->latest()->paginate(5),
            //'staff_months'  => Winner::where('month_id', '=', $staff_month)->with('user.department')->with('branch')->get(),
            //'notices'       => Notice::orderBy('created_at', 'DESC')->paginate(3),
        ]);
    }

    public function staff()
    {
        //$membership = Member::select('room_id')->where('user_id', '=', auth('api')->id())->where('status', '=', 1);
        //$chats = Room::whereIn('id', $membership)->with('messages.user')->with('members.user')->orderBy('updated_at', 'DESC')->paginate(10);
        //$activities = Activity::where('user_id', '=', auth('api')->id())->latest()->get();
        
        return response()->json([
            'new_users'     => User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-14 days')))->latest()->with(['area','state','roles'])->count(),
            'pending_provider' => Doctor::where('status', '<=', 1)->count(),
            'pending_agency' => Agency::where('status', '<=', 1)->count(),
            'pending_stories' => BlogPost::where('status', '<=', 1)->count(),
            //'message_rooms' => Member::where('user_id', '=', auth('api')->id())->with('room.messages')->get(),
            'new_staffs'    => User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-14 days')))->count(),
            //'tickets'       => Ticket::where('agent_id', '=', auth('api')->id())->orWhere('category_id', '=', auth('api')->user()->department_id)->with(['creator', 'category', 'status', 'priority'])->latest()->paginate(5),
            //'notices'       => Notice::orderBy('created_at', 'DESC')->paginate(3),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //npm
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    private function staff_months($i){
        if (!is_numeric($i)){return $i;}
        $date = date('Y-m-01', strtotime("-".$i." months"));
        
        $staff_month = Month::where('month', '=', $date)->with('winners')->first(); 
        
        if ($staff_month && (count($staff_month->winners) != 0)){ 
            return $staff_month->id;
        }
        else { return $this->staff_months($i+1); }
    }
}
