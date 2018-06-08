<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
class AdminShowController extends Controller
{
    /**
     * @var AdminRepository
     */
    public $admin;

    /**
     * AdminController constructor.
     * @param AdminRepository $admin
     */
    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }

    //管理员主页

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $collects = $this->admin->dashboard_init_data();
        return view('admin.dashboard.index', compact('collects'));
    }

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
        return redirect('admin');
    }

    public function logout(){
        session()->forget('admin');
        return redirect('admin/login');
    }
}
