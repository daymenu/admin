<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function info(Request $request)
    {
        $user = $request->user();
        return ['code' => 200, 'data' => $user->toArray()];
    }
}
