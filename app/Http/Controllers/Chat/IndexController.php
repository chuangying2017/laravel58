<?php

namespace App\Http\Controllers\Chat;

use App\Model\Customer;
use App\Model\SessionRecord;
use App\Repository\Chat\Member;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Predis\Client;

class IndexController extends Controller
{
    protected $member;

    protected $ws = 'ws://192.168.2.127:9501';

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    //客服登录的聊天系统 好像成功上传了 现在测试一下
    public function chatShow(Request $request)
    {
        return view('chat.chat', ['server' => $this->ws,'user' => $request->session()->get('user')]);
    }

    public function login()
    {
        return view('chat.login');
    }

    public function clientChat(Request $request)
    {
        $arr =  ['server' => $this->ws];

        $string = $request->input('string',null);

        if ($string)
        {
            $random = character(8);

            try{
//                $user = decrypt($string);

                $user = Customer::find($string);

                if (in_array($user->status, Customer::LOGIN_STATUS))
                {
                    return redirect()->action('RedirectController@qrcodeDecode',['string'=>$request->input('qrcode')]);
                }

                $arr['customer'] = $user->toArray();
                $arr['customer']['avatar'] = makeGravatar($arr['customer']['number']. '@swoole.com');
            }catch (DecryptException $exception)
            {
                Log::error($exception->getMessage());

                return response()->json(['msg' => $exception->getMessage()]);
            }
            //生成客户类型

            $number = 'KF_'.$random;
            $avatar = makeGravatar($random. '@swoole.com');
            $arr_name = config('app.client_name');
            $array = ['number' => $number, 'avatar' => $avatar,'intro' => '客服咨询', 'name' => $arr_name[array_rand($arr_name,1)]];

            $arr['client'] = $array;

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

    public function uploadFile(Request $request)
    {
            $path = Storage::disk('public')->putFile('chat_image',$request->file('image'),'public');

            return response()->json(['status' => 1,'path' => Storage::url($path)]);

    }

    public function sessionRecord(Request $request)
    {
        $arr = $this->member->select_session($request->all());

        return response()->json(['status' => 1, 'msg'=> $arr]);
    }

    public function updateAvatar(Request $request)
    {
        $path = Storage::disk('public')->putFile('chat_avatar', $request->file('image'),'public');

        return response()->json(['status' => 1, 'path' => Storage::url($path)]);
    }
}
