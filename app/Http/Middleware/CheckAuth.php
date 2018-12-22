<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = $request->user()->id;
        $user = new User();
        $routes = $user->apis($userId);
        $route = Route::currentRouteName();
        if (!in_array($route, $routes)) {
           return response(['code' => 100010, 'message'=>'没有权限']);
        }
        return $next($request);
    }
}
