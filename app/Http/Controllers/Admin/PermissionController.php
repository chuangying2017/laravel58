<?php

namespace App\Http\Controllers\Admin;


use App\Repository\Permission\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $RepositoryPermission;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->RepositoryPermission = $permissionRepository;
    }

    public function index(Request $request)
    {
        return view('admin.admin-permission');
    }

    public function permissionAddShow(Request $request)
    {
        return view('admin.permission-add');
    }
}
