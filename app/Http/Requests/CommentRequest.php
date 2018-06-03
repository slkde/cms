<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'article_id'   =>  'required|exists:articles,id',
		    'content'      =>  'required',
        	'captcha'      =>  'required|captcha'
        ];
    }

    public function messages(){
        return [
        	'content.required'       => '请填写具体内容',
        	'captcha.required'       => '请填写验证码',
        	'captcha.captcha'        => '验证码不正确'
        ];
    }
}
