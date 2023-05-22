<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\LogActivity;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            $log_activity = LogActivity::create([
                'subject' => 'User '.Auth::user()->first_name.' '.Auth::user()->last_name.' successfully logged in', 
                'url' => 'This is a test', 
                'method' => 'post', 
                'ip' => \Illuminate\Support\Facades\Request::ip(), 
                'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                'user_id' => Auth::id(),
            ]);
            
            Auth::user()->generateCode();
  
            return redirect()->route('2fa.index');
        }
        else{
            $log_activity = LogActivity::create([
                'subject' => 'Attempted logged in failed', 
                'url' => 'This is a test', 
                'method' => 'post', 
                'ip' => \Illuminate\Support\Facades\Request::ip(), 
                'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                'user_id' => NULL,
            ]);
            return redirect()->route('login')->with('error','Email-Address And Password Are Wrong.');
        }
          
    }
}
