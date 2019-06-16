<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MemberRequest;
use App\Repository\Chat\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    protected $memberRepository;

    protected $request;

    public function __construct(Member $member)
    {
        $this->memberRepository = $member;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param MemberRequest $request
     * @return void
     */
    public function create(MemberRequest $request)
    {

    }


    /**
     * @param MemberRequest $request
     * @return Json
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(),[
            'username' => 'required|min:6|max:20|unique:customer',
            'password' => 'required|min:6|max:25'
        ],[
            'username.required' => '用户名不能为空',
            'username.max' => '最大长度20',
            'password.required' => '密码不能为空',
            'password.max' => '密码最大长度25',
            'username.min' => '账号最小长度6',
            'password.min' => '密码最小长度6',
            'username.unique' => '账号已存在'
        ]);

        if ($validate->fails())
        {
            $result = ['status' => 2, 'msg' => $validate->getMessageBag()->first()];
        }else{
            $result = $this->memberRepository->save($request->post());
        }

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json($this->memberRepository->delete($id));
    }

    /**
     * @param Request $request
     * @return JsonResource
     */
    public function statusEdit(Request $request)
    {
        $data = $request -> post();
        return response()->json($this->memberRepository->edit($data['id'],$data));
    }
}
