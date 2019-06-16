<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Repository\Admin\AdminRepository;
use App\Repository\Role\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $roleRepository;

    protected $adminRepository;

    public function __construct(RoleRepository $repository,AdminRepository $adminRepository)
    {
        $this->roleRepository = $repository;
        $this->adminRepository = $adminRepository;
    }

    public function index(Request $request)
    {
        return view('admin.admin-list', ['arr' => $this->adminRepository->select()]);
    }

    public function addShow()
    {
        return view('admin.admin-add', ['role' => $this->roleRepository->select(false)]);
    }

    public function addPost(Request $request)
    {
        return response()->json($this->adminRepository->create($request->post()));
    }

    public function editShow(Request $request)
    {
        $arr = $this->adminRepository->find((int)$request->get('id'));

        return view('admin.admin-edit', ['role' => $this->roleRepository->select(false), 'arr' => $arr]);
    }

    public function editPost(Request $request)
    {
        $data = $request->post();

        return response()->json(status($this->adminRepository->update($data['id'],$data)));
    }

    public function changePasswordShow()
    {

    }

    public function changePasswordPost(Request $request)
    {

    }

    public function userStatusDisable($id)
    {
        return response()->json(status($this->adminRepository->editStatus($id,User::STATUS_FORBIDDEN)));
    }

    public function userStatusEnable($id)
    {
        return response()->json(status($this->adminRepository->editStatus($id,User::STATUS_ACTIVE)));
    }

    public function delete($id)
    {
        return response()->json($this->adminRepository->delete($id));
    }
}
