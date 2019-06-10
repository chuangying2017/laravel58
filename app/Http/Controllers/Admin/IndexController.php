<?php

namespace App\Http\Controllers\Admin;

use App\Repository\Chat\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }

    public function welcome()
    {
        return view('public.welcome', ['systeminfo' => getSystemInfo()]);
    }

    public function member_list(Member $member)
    {
        return view('admin.member_list', ['member' => $member->select()]);
    }

    public function member_add()
    {
        return view('admin.member_add');
    }

    public function changePassword()
    {
        return view('admin.change_password');
    }

    public function chat_record(Member $member)
    {
        $all = \request()->all();
        return view('admin.record', [
            'record' => $member->array_each($member->chat_get($all)),
            'search_startTime' => $all['search_starttime'] ?? null,
            'search_endTime' => $all['search_endtime'] ?? null,
            'search_username' => $all['search_username'] ?? null
            ]);
    }
}
