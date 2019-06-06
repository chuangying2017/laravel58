<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:6|max:20|unique:customer',
            'password' => 'required|min:6|max:25'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.max' => '最大长度20',
            'password.required' => '密码不能为空',
            'password.max' => '密码最大长度25',
            'username.min' => '账号最小长度6',
            'password.min' => '密码最小长度6',
            'username.unique' => '账号已存在'
        ];
    }
}
