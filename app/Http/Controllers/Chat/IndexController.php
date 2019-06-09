<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //客服登录的聊天系统
    public function chatShow()
    {
        return view('chat.chat', ['server' => 'ws://127.0.0.1:9501']);
    }

    public function login()
    {
        return view('chat.login');
    }
}
