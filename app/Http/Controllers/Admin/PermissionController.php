<?php

namespace App\Http\Controllers\Admin;


use App\Repository\InterfaceRepository\CurdInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $RepositoryPermission;

    public function __construct(CurdInterface $permissionRepository)
    {
        $this->RepositoryPermission = $permissionRepository;
    }

    public function index(Request $request)
    {
        return view('admin.admin-permission', ['arr' => $this->RepositoryPermission->get($request->only('search'))]);
    }

    public function permissionAddShow(Request $request)
    {
        return view('admin.permission-add', ['arr' => $this->RepositoryPermission->select()]);
    }

    public function permissionAddPost(Request $request)
    {
        $result = $this->RepositoryPermission->create($request->except('_token'));

        return response()->json($result);
    }

    public function permissionDelete(Request $request)
    {
        $result = $this->RepositoryPermission->delete($request->only('id')['id']);

        return response()->json(status($result));
    }

    public function permissionEditShow($id)
    {
        return view('admin.permission-edit', ['arr' => $this->RepositoryPermission->find((int)$id)]);
    }

    public function permissionEditPost(Request $request)
    {
        $result = $this->RepositoryPermission->updateLogic($request->all());

        return response()->json(status($result));
    }
}
