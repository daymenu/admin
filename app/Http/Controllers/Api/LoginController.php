<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use GuzzleHttp\Client;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginRecord;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $userModel = User::where(function ($query) use ($username) {
            $query->orWhere('user_name', $username)->orWhere('email', $username);
        });
        $user = $userModel->first();

        if (!$user) {
            return $this->apiFaild('用户名不存在');
        }
        $loginRecord = new LoginRecord();
        $record['adminId'] = $user->id;
        $record['ip'] = $request->getClientIp();
        if (!Hash::check($password, $user->password)) {
            $record['status'] = 2;
            $loginRecord->record($record);
            return $this->apiFaild('密码错误');
        }

        $loginRecord->record($record);
        $http = new Client();
        $forms = [
            'form_params' => [
                'grant_type' => config('passport.grant_type'),
                'client_id' => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'username' => $user->email,
                'password' => $password,
                'scope' => '*',
            ],
        ];
        $response = $http->post('http://admin.daymenu.cn/oauth/token', $forms);
        return $this->apiSuccess(json_decode((string)$response->getBody(), true));
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
            return $this->apiSuccess([], '退出成功');
        } else {
            return $this->apiFaild('退出成功');
        }
    }
}
