<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCode;
use Session;

class DoubleAuthenticationController extends Controller
{
    
    public function index()
    {
        return view('double_auth');
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);
  
        $find = UserCode::where('user_id', auth()->user()->id)
                        ->where('code', $request->code)
                        ->where('updated_at', '>=', now()->subMinutes(2))
                        ->first();
  
        if (!is_null($find)) {
            Session::put('user_2fa', auth()->user()->id);
            return redirect()->route('home');
        }
  
        return back()->with('error', 'You entered wrong code.');
    }
    
    public function resend()
    {
        auth()->user()->generateCode();
  
        return back()->with('success', 'We sent you code on your mobile number.');
    }
    
    public function show($id)
    {
        //
    }

    public function edit($id)
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
