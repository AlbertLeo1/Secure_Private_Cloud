<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $params = [
            'page_title' => 'Administrator ',
        ];
        return view('learn.admin')->with($params);
    }
}
