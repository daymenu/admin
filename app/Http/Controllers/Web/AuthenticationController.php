<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function redirect($account)
    {
        try {
            return Socialite::driver($account)->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect('/');
        }
    }

    public function callback($account)
    {
    // 从第三方 OAuth 回调中获取用户信息
        $socialUser = Socialite::driver($account)->user();
    // 在本地 users 表中查询该用户来判断是否已存在
        $user = User::where('provider_id', '=', $socialUser->id)
            ->where('provider', '=', $account)
            ->first();
        if ($user == null) {
        // 如果该用户不存在则将其保存到 users 表
            $newUser = new User();

            $newUser->name = (string)$socialUser->getName();
            $newUser->email = (string)$socialUser->getEmail() == '' ? '' : $socialUser->getEmail();
            $newUser->avatar = (string)$socialUser->getAvatar();
            $newUser->password = '';
            $newUser->provider = (string)$account;
            $newUser->provider_id = (int)$socialUser->getId();

            $newUser->save();
            $user = $newUser;
        }

    // 手动登录该用户
        Auth::login($user);

    // 登录成功后将用户重定向到首页
        return redirect('/');
    }
}
