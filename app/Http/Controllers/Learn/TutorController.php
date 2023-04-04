<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorController extends Controller
{
    public function index()
    {
        $params = ['page_title' => 'Tutor Portal',];
        return view('learn.tutor')->with($params);
    }
}
