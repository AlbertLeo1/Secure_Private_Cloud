<?php

namespace App\Http\Controllers\Api\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LogActivity;

class LogController extends Controller
{
    public function index()
    {
        $log_activity = LogActivity::create([
            'subject' => 'User '.auth('api')->user()->first_name.' '.auth('api')->user()->last_name.' pull all log activities', 
            'url' => 'This is a test', 
            'method' => 'read', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => auth('api')->id(),
        ]);

        return response()->json([
            'log_activities' => LogActivity::latest()->paginate(30),
        ]);
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
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
