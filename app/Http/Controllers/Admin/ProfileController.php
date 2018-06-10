<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    //
    public function index(){
        return view('admin.profile.index');
    }

    public function update($id, ProfileRequest $request){
        $item = User::find($id);
        if(! $item){
            abort(404);
        }
        if(! $item->id === \Auth::user()->id){
            abort(404);
        }
        $input = $request->except('_token','_method','password_confirmation');
        foreach($input as $k=>$v){
            if(empty($input[$k])){
                unset($input[$k]);
            }
        }
        if(isset($input['password'])){
            $input['password'] = bcrypt($input['password']);
        }
        // dd($input);
        if($item->update($input)){
            return redirect()->back()->with('success', '操作成功');
        }else{
            return redirect()->back()->with('error', '操作失败');
        }
        
    }
}
