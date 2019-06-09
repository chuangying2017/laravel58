<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChatAuthMiddleware
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
        if (!$request->session()->has('user'))
        {
            return redirect(route('chat.login'));
        }
        return $next($request);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('chat.login');
        }
    }
}
