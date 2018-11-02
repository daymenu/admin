<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $http = new Client();
        $response = $http->post('http://admin.daymenu.cn/oauth/token', [
            'form_params' => [
                'grant_type' => config('passport.grant_type'),
                'client_id' => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'username' => $username,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        return $this->apiSuccess(json_decode((string)$response->getBody(), true));
    }

    public function logout(Request $request)
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
            return $this->apiSuccess([],'退出成功');
        } else {
            return $this->apiFaild('退出成功');
        }
    }
}
