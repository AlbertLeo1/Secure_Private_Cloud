<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function dashboard()
    {
        $params = [
            'page_title' => 'Dashboard',
        ];
        return view('internet')->with($params);
    }

    
    public function human_resources()
    {
        $params = [
            'page'       => 'hr',
            'page_title' => 'Human Resources',
        ];
        return view('users')->with($params);
    }

    public function internet()
    {
        $params = [
            'page_title' => 'Internet',
        ];
        return view('internet')->with($params);
    }

    public function inventory()
    {
        $params = [
            'page_title' => 'Inventory',
        ];
        return view('users')->with($params);
    }

    public function learn()
    {
        $params = [
            'page'       => 'learn',
            'page_title' => 'Learning Area',
        ];
        return view('users')->with($params);
    }

    public function notices()
    {
        $params = ['page_title' => 'Notice Board',];
        return view('notices')->with($params);
    }

    public function nursing()
    {
        $params = [
            'page'       => 'nursing',
            'page_title' => 'Nursing Care',
        ];
        return view('users')->with($params);
    }

    public function policies()
    {
        $params = [
            'page'       => 'policies',
            'page_title' => 'Policies',
        ];
        return view('users')->with($params);
    }

    public function profile()
    {
        $params = [
            'page' => 'Profile',
            'page_title' => 'Profile',
        ];
        return view('user')->with($params);
    }

    public function settings()
    {
        $params = [
            'page_title' => 'Settings',
        ];
        return view('settings')->with($params);
    }

    public function staff_month()
    {
        $params = [
            'page_title' => 'Staff of the Month',
        ];
        return view('som')->with($params);
    }

    public function ticketing()
    {
        $params = [
            'page_title' => 'Tickets',
        ];
        return view('tickets')->with($params);
    }

    public function users()
    {
        $params = [
            'page_title' => 'Users',
        ];
        return view('users')->with($params);
    }
}
