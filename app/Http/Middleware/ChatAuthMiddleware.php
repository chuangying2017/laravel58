<?php

namespace App\Http\Middleware;

use App\Model\Customer;
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
        $user = $request->session()->get('user',null);

        if (!$user)
        {
            return redirect(route('chat.login'));
        }

        if (in_array($user['status'],Customer::LOGIN_STATUS))
        {
            return redirect(route('admin.alert_message',['chat_url' => true]))->with('tip','您好，该客服被禁用');
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
