<?php

namespace App\Http\Controllers\Chat;

use App\Model\Customer;
use App\Model\ModelConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;


class UserDataHandleController extends Controller
{
    public function authLogin(Request $request)
    {
        $data = $request->post();

        $res = Customer::where('username',$data['username'])->where('password',base64_encode($data['password']))->first();

        if ($res)
        {
            if (in_array($res['status'],['inactive','discard']))
            {
                return ['status'=>'2','msg'=>'当前客服为禁用状态'];
            }
            $session = $request->getSession();

            $session->put('user',$res);

            $result = ['status'=>'1','msg'=>'success','src'=>route('chat.show')];

        }else{
            $result = ['status'=>'2','msg'=>'账号或密码错误'];
        }

        return response()->json($result);
    }

    public function loginOut(Request $request)
    {
        $request->session()->flush();

        Cookie::clearResolvedInstances();

        return response()->json(['status'=>'1','msg'=>'success','src'=>route('chat.login')]);
    }
}
