<?php

namespace App\Http\Controllers\Caiji;

use App\Repository\Active\ActiveRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApiActiveController extends Controller
{

    protected $activeRepository;

    public function __construct(ActiveRepository $activeRepository)
    {
        $this->activeRepository = $activeRepository;
    }

    public function insert(Request $request)
    {
        $post = $request->post();

        $res = $this->activeRepository->save($post);

        return response()->json($res)->setStatusCode(201);
    }

    public function test()
    {
        $res = $this->activeRepository->save();
        dd($res);
    }
}
