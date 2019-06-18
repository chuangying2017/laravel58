<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    //客服登录的聊天系统
    public function chatShow(Request $request)
    {
        return view('chat.chat', ['server' => 'ws://47.105.186.89:9501','user' => $request->session()->get('user')]);
    }

    public function login()
    {
        return view('chat.login');
    }

    public function clientChat(Request $request)
    {
        $arr =  ['server' => 'ws://47.105.186.89:9501'];

        $string = $request->input('string',null);

        if ($string)
        {
            $random = character(8);

            try{
                $user = decrypt($string);
                $arr['customer'] = $user instanceof Model ? $user->toArray() : $user;
                $arr['customer']['avatar'] = makeGravatar($arr['customer']['number']. '@swoole.com');
            }catch (DecryptException $exception)
            {
                Log::error($exception->getMessage());
            }
            //生成客户类型

            
            if (!$request->cookie('number'))
            {

                $number = 'KF_'.$random;
                $avatar = makeGravatar($random. '@swoole.com');

            }else{

                $number = Cookie::get('number');
                $avatar = Cookie::get('avatar');
            }
            
            $arr['client'] = [
                'avatar' => $avatar,
                'number' =>$number,
                'intro' => '客服咨询'
            ];

        }else{

            return redirect(route('admin.alert_message'))->with('tip','抱歉您没有权限进来');

        }

        return view('chat.clientChat', $arr);
    }
}
