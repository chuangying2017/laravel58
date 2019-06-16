<?php

namespace App\Http\Controllers\Admin;

use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $RoleRepository;

    protected $PermissionRepository;

    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->RoleRepository = $repository;
        $this->PermissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        return view('admin.admin-role', ['arr' => $this->RoleRepository->select()]);
    }

    public function addShow()
    {
        $allPermission = $this->PermissionRepository->get();
        $arr = [];
        foreach ($allPermission as $k => $v)
        {
            if ($v['pid'] <= 0)
            {
                $arr[$v['id']]['parent'] = $v;
            }else{
                //

                $count = substr_count($v['path'],'-');

                if ($count > 1)
                {
                    //三级分类
                    $value = explode('-',$v['path']);

                    $min = collect($value)->min();

                    $arr[$min]['children'][$v['pid']]['children'][] = $v;
                }else{
                    //二级分类
                    $arr[$v['pid']]['children'][$v['id']]['parent'] = $v;
                }

            }
        }

        return view('admin.admin-role-add',['arr' => $arr]);
    }

    public function roleAddPost(Request $request)
    {
        return response()->json($this->RoleRepository->create($request->post()));
    }

    public function roleEditShow($id)
    {

    }

    public function roleEditPost()
    {

    }

    public function roleDelete(Request $request)
    {
        return response()->json(status($this->RoleRepository->delete($request->post('id'))));
    }
}
