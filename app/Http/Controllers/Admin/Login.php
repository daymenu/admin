<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common;

class Login extends Controller
{
    //
    public function index(Request $request)
    {
        return view('admin/login');
    }

    public function login(Request $request)
    {

    }
}
