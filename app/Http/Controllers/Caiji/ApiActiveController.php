<?php

namespace App\Http\Controllers\Caiji;

use App\Repository\Active\ActiveRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
        try {
            $res = $this->activeRepository->save();
        } catch (FileNotFoundException $e) {
            $res = $e->getMessage();
        }
        dd($res);
    }
}
