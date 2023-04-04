<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\EMR\Agency;
use App\Models\EMR\Doctor;
use App\Models\EMR\Hospital;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_type' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'agency_type' => ['sometimes', 'numeric'],
            'provider_type' => ['sometimes', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        if ($data['user_type'] == 'agency'){
            $agency = Agency::create([
                'name' => $data['agency_name'],
                'agency_type' => $data['agency_type'],
                'created_by' => $user->id,
            ]);
            $user->assignRole('Agency');
        }
        else if (($data['user_type'] == 'provider') && ($data['provider_type'] == 1)){
            $hospital = Hospital::create([
                'name' => $data['hospital_name'],
                'created_by' => $user->id,
            ]);
            $doctor = Doctor::create([
                'user_id' => $user_id,
                'hospital_id' => $hospital->id,
                'hospital_name' => $hospital->name,
                'created_by' => $user->id,
            ]);

            $user->assignRole('Consultant', 'Hospital');
        } 
        else if (($data['user_type'] == 'provider') && ($data['provider_type'] != 1)){
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'hospital_name' => $data['hospital_name'],
                'created_by' => $user->id,
            ]);

            $user->assignRole('Consultant');
        } 
        return $user; 
    }
}
