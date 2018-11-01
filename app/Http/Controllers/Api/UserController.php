<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function info(Request $request)
    {
        $accessToken  = $request->input('access_token');
        return ['code' => 200, 'data' => $accessToken];
    }
}
