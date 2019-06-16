<?php

namespace App\Http\Middleware;

use App\Repository\Role\RoleVerify;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckRoleMiddleware
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
        $user = $request->user();

        $role = $user->role->first();

        if (!$role)
        {
            return redirect(\route('admin.alert_message'))->with('tip','权限不足');
        }

        $currentRoute = Route::currentRouteName();

        if (in_array($currentRoute,RoleVerify::EXCEPT_ROUTE))
        {
            return $next($request);
        }

        $res = $role->permission()->where('action',$currentRoute)->first();

       if (!$res)
       {
           return redirect()->route('admin.alert_message')->with('tip','权限不足');
       }



        return $next($request);
    }

    /**
     * @param Request $request
     */
    public function redirectTo(Request $request)
    {
            if (!$request->expectsJson())
            {
                return \route('admin.login');
            }
    }
}
