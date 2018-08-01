<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'category_id'    =>  'required|exists:categorys,id',
            'district_id'    =>  'required|exists:districts,id',
            'expired_days'   =>  'required|alpha_num',
            'title'          =>  'required|min:6',
            'content'        =>  'required',
            'tel'            =>  ['required', 'regex:/^1[3|4|5|7|8|9][0-9]\d{8}$/'],
            'manage_passwd'  =>  'required|min:4',
            'images.*'       =>  'image|max:2048',
            'captcha'        =>  'required|captcha'
        ];
    }

    public function messages(){
        return [
            'category_id.required'   => '请选择栏目',
            'district_id.required'   => '请选择区域',
            'expired_days.required'  => '请选择有期限期',
            'title.required'         => '标题不能为空',
            'title.min'              => '标题至少6个字，请用一句话概括信息。',
            'content.required'       => '请填写具体内容',
            'tel.required'           => '手机号不能为空',
            'tel.regex'              => '手机号码格式错误',
            'manage_passwd.required' => '管理密码不能为空',
            'manage_passwd.min'      => '管理密码至少4位',
            'images.image'           => '图像上传失败，请确认您上传的文件是图像？',
            'images.max'             => '图像上传失败，上传的图像太大啦，确保图像小于1M',
            'captcha.required'       => '请填写验证码',
            'captcha.captcha'        => '验证码不正确'
        ];
    }
}
