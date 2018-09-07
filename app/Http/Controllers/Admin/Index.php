<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Admin\Admin as AdminModel;

class Index extends Controller
{
    //
    public function index(Request $request)
    {
        return view('admin/index');
    }
}
