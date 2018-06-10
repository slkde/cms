<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'                   =>  'nullable',
            'email'                  =>  'nullable|email',
            'password'               =>  'nullable|between:6,12|confirmed',
        ];
    }

    public function messages(){
        return [
            'email.email'            => '请输入一个正确的邮箱地址',
            'password.between'       => '密码为6到12位',
            'password_confirmation.confirmed'  => '确认密码'
        ];
    }
}
