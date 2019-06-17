<?php

namespace App\Http\Controllers\Admin;

use App\Repository\Chat\Member;
use App\Repository\InterfaceRepository\CurdInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    protected $permissionRepository;

    public function __construct(CurdInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        $res = $request->user()->role->first()->permission()->get();
        //$res = $this->permissionRepository->get();

        $arr = [];

        foreach ($res as $k => $v)
        {
            if ($v['pid'] <= 0)
            {

                $str = $v['style'];

                if (strpos($str,'.') !== false)
                {
                    $style = explode('.',$str);
                }else{
                    $style = [];
                }
                $v['style'] = $style;

                $arr[$v['id']]['parent'] = $v;
            }else{
                //

                $count = substr_count($v['path'],'-');

                if ($count > 1)
                {
                    //三级分类
                    $value = explode('-',$v['path']);

                    $min = collect($value)->min();

                    $arr[$min]['children'][$v['pid']]['children'] = $v;
                }else{
                  //二级分类
                    $arr[$v['pid']]['children'][$v['id']] = $v;
                }

            }
        }

        return view('admin.index', ['arr' => $arr]);
    }

    public function welcome()
    {
        return view('public.welcome', ['systeminfo' => getSystemInfo()]);
    }

    public function member_list(Member $member)
    {
        return view('admin.member_list', ['member' => $member->select(request()->user()->id)]);
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
