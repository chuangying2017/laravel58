<?php

namespace App\Http\Controllers\Chat;

use App\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserDataHandleController extends Controller
{
    public function authLogin(Request $request)
    {
        $data = $request->post();

        $res = Customer::where('username',$data['username'])->where('password',base64_encode($data['password']))->find();

        if ($res->count())
        {
            $session = $request->getSession();

            $session->put('user',$res);
        }else{

            return response()->json(['status'=>'1','msg'=>'success','src'=>route('chat.show')]);
        }
    }

    public function loginOut(Request $request)
    {
        $request->session()->flush();

        return response()->json(['status'=>'1','msg'=>'success','src'=>route('chat.login')]);
    }
}
