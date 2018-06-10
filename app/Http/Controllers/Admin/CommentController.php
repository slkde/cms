<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function index(Request $request){
        $s = $request->input('search');
        if($s){
            $data = Comment::where('content','like', trim('%'. $s. '%'))->latest('created_at')->Paginate(20);
        }else{
            $data = Comment::latest('created_at')->Paginate(20);
        }
        return view('admin.comments.index', compact('data', 's'));
    }

    public function edit($id){
        $item = Comment::find($id);
        if(!$item){
            abort(404);
        }
        return view('admin.comments.edit', compact('item'));
    }

    public function update($id, Request $request){
        $item = Comment::find($id);
        $input['content'] = $request->input('content');
        // dd($input);
        if(!$item){
            abort(404);
        }
        if(!$item->update($input)){
            $request->flash();
            return redirect()->back();
        }
        return redirect('/admin/comment');
    }

    public function destroy($id){
        $item = Comment::find($id);
        if(!$item){
            abort(404);
        }
        if(!$item->delete()){
            return response()->json(['static'=>'false']);
        }else{
            return response()->json(['static'=>'true']);
        }
    }

    public function verify(Request $request){
        $id = $request->input('id');
        $verify = $request->input('is_verify');
        $item = Comment::find($id);
        if(!$item){
            abort(404);
        }
        if(!$item->update(['is_verify' => $verify])){
            return response()->json(['static' => 'false']);
        }else{
            return response()->json(['static' => 'true']);
        }
    }
}
