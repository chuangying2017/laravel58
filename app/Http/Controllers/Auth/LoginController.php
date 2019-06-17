<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return response()->json(['status'=>2, 'msg' => Lang::get('auth.throttle', ['seconds' => $seconds])]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
      return response()->json(['status' => 2, 'msg' => Lang::get('auth.failed')]);
    }


    /**
     * login success response
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated(Request $request, $user)
    {
       switch ($user->status)
       {
           case User::STATUS_FORBIDDEN:
               $result = ['status'=>2,'msg' => Lang::get('auth.forbidden')];
               break;
           case User::STATUS_DELETE:
               $result = ['status' => 2, 'msg' => Lang::get('auth.delete')];
               break;
           case User::STATUS_ACTIVE:
               $result = ['status' => 1, 'msg'=> Lang::get('auth.success'), 'url' => route('admin.index')];
               break;
           default:
               $result = ['status' =>2, 'msg' => Lang::get('auth.status_fail') ];
               break;
       }

       if ($user->status != User::STATUS_ACTIVE)
       {
           $this->guard()->logout();

           $request->session()->invalidate();
       }

       return response()->json($result);
    }

    public function username()
    {
        return 'name';
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function loggedOut(Request $request)
    {
        return redirect('/auth/login');
    }
}
