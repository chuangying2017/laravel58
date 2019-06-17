<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class RedirectController extends Controller
{

    public function index()
    {
        return view('point.redirect_alert', ['arr' => \request()->all()]);
    }

    /**
     * parse address
     * @param string $string
     */
    public function qrcodeDecode($string)
    {

        try{
            $arr = decrypt($string);

            $user = User::find($arr['user_id']);

            if (!$user)
            {
                return redirect(route('admin.alert_message'))->with('tip','代理商不存在');
            }

            if (in_array($user->status, [User::STATUS_DELETE,User::STATUS_FORBIDDEN]))
            {
                return redirect(route('admin.alert_message'))->with('tip','代理商已被禁用或删除');
            }

            $customer = $user->customer()->status()->get();

            if (empty($customer->toArray()))
            {
                return redirect(route('admin.alert_message'))->with('tip','代理商下面暂无客服');
            }

            $random = $customer->random();

            return redirect()->action('Chat\\IndexController@clientChat',['string' => encrypt($random)]);
        }catch (DecryptException $exception)
        {
            return $exception->getMessage();
        }

    }
}
