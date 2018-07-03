<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function login(){
        if(session()->has('admin')){
            return redirect('admin');
        }
        return view('admin.login.index');
    }

    public function dologin(Request $request){
        $input = $request->except('_token');
        if(!\Auth::attempt($input)){
            $request->flash();
            return redirect()->back()->withError(['check' => '用户名或密码错误']);
        }
        User::where(['id'=>\Auth::user()->id])->update(['ip'=>$request->ip()]);
        session(['admin' => $input['name']]);
        return redirect('279497165');
    }

    public function logout(){
        session()->forget('admin');
        return redirect('279497165/login');
    }
}
