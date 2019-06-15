<?php

namespace App\Http\Controllers\Admin;

use App\Repository\Role\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $RoleRepository;

    public function __construct(RoleRepository $repository)
    {
        $this->RoleRepository = $repository;
    }

    public function index(Request $request)
    {
        return view('admin.admin-role');
    }
}
