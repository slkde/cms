<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = User::latest('created_at')->Paginate(10);
        return view('admin.users.index', compact('data'));
    }

    public function edit($id){
        $item = User::find($id);
        return view('admin.users.edit', compact('item'));
    }

    public function update($id, ProfileRequest $request){
        $item = User::find($id);
        if(! $item){
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
            return redirect()->back()->with('success', 'Profile updated!');
        }else{
            return redirect()->back()->with('error', 'Profile updated!');
        }
    }
}
