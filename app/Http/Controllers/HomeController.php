<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'double_auth']);
    }

    public function index()
    {
        $params = $params = [
            'page'       => 'home',
            'page_title' => 'Dashboard',
        ];
        return view('users')->with($params);
    }
}
