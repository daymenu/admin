<?php

namespace App\Http\Middleware\Admin;

use Closure;

class UserInfo
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
        view()->share('data','欢迎你！');
        return $next($request);
    }
}
