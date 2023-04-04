<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        $params = ['page_title' => 'Student Portal',];
        return view('learn.student')->with($params);
    }
}
