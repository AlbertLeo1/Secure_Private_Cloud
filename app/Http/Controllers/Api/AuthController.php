<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $attrs = $request->validate([
            'username'      => 'required', 
            'password'      => 'required|string|min:8',       
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(!auth()->attempt(array($fieldType => $attrs['username'], 'password' => $attrs['password']))){
        //if(!Auth::attempt($attrs)){
            return response([
                'message' => 'Invalid Login Parameters'
            ], 403);
        }
        
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->accessToken 
        ], 200);
    }

    public function logout(Request $request)
    {
        auth('api')->user()->tokens()->delete();

        return response([
            'message' => 'Log Out was successful',
        ], 200);
    }

    public function register(Request $request)
    {
        $attrs = $request->validate([
            'first_name'    => 'required|string', 
            //'middle_name'   => 'nullable|string', 
            'last_name'     => 'required|string', 
            //'bvn'           => 'nullable|number', 
            'email'         => 'required|email|unique:users,email', 
            'password'      => 'required|string|min:8', 
            //'user_type'     => 'required|integer',      
        ]);

        $user = User::create([
            'first_name'          => $attrs['first_name'],
            'last_name'           => $attrs['last_name'],
            'email'               => $attrs['email'],
            'password'            => bcrypt($attrs['password']),
            'user_type'           => $attrs['user_type'],
        ]);

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->accessToken 
        ],200);
    }

    public function user(){
        return response([
            'user' => auth('api')->user()
        ], 200);
    }

    public function update(Request $request){
        $attrs = $request->validate([
            'first_name'    => 'required|string', 
            'middle_name'   => 'nullable|string', 
            'last_name'     => 'required|string', 
            'email'         => 'required|email|unique:users,email', 
            'password'      => 'required|string|min:8', 
            'user_type'     => 'required|number',      
        ]);

        $image = $this->saveImage($request->image, 'profile', 'jpg');

        $user = User::find(auth('api')->id());
        $old_image = $user->image; 
        $user->first_name          = $attrs['first_name'];
        $user->last_name           = $attrs['last_name'];
        $user->email               = $attrs['email'];
        $user->password            = bcrypt($attrs['password']);
        $user->user_type           = $attrs['user_type'];
        $user->image               = $image ?? $old_image; 

        $user->save();

        return response(['user' => auth('api')->user()], 200);
    }
}
