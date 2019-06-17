<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                $arr['customer'] = decrypt($string);
                $arr['customer']['avatar'] = makeGravatar(character(8). '@swoole.com');
            }catch (DecryptException $exception)
            {
                Log::error($exception->getMessage());
            }
            //生成客户类型

            $arr['client'] = [
                'avatar' => makeGravatar($random. '@swoole.com'),
                'number' =>'KF_'.$random,
                'intro' => '客服咨询'
            ];

        }else{

            return redirect(route('admin.alert_message'))->with('tip','抱歉您没有权限进来');

        }

        return view('chat.clientChat', $arr);
    }
}
