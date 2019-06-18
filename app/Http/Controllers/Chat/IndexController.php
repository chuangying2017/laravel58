<?php

namespace App\Http\Controllers\Chat;

use App\Repository\Chat\Member;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Predis\Client;

class IndexController extends Controller
{
    protected $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

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

        /*    $ip = $request->ip();

            $predis = new Client();

            $string = $predis->get($ip);

            if ($string)
            {
                $array = unserialize($string);
            }else{
                $number = 'KF_'.$random;
                $avatar = makeGravatar($random. '@swoole.com');
                $array = ['number' => $number, 'avatar' => $avatar,'intro' => '客服咨询'];
                $predis->setex($ip,3600,serialize($array));
            }

            $arr['client'] = $array;*/


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

    public function userUpdate(Request $request)
    {
        $res = $this->member->edit($request->get('id'),$request->only('name'));

        return response()->json($res);
    }
}
