<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:10'
        ];
    }

    /**
     * 错误信息
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute是必填项',
            'email' => ':attribute格式不对',
            'min' => ':attribute不能少于6位',
            'max' => ':attribute不能大于10位'
        ];
    }

    /**
     * 验证的字段
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => '邮箱',
            'password' => '密码',
            'name' => '账户'
        ];
    }
}
