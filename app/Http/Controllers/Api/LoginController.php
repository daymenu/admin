<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $username  = $request->input('username');
        $password  = $request->input('password');
        $http = new Client();
        $response = $http->post('http://admin.daymenu.cn/oauth/token', [
            'form_params' => [
                'grant_type' => config('passport.grant_type'),
                'client_id' => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'username' => $username,
                'password' => $password,
                'scope' => '',
            ],
        ]);
        return ['code' => 200, 'data' => json_decode((string) $response->getBody(), true)];
    }
}
