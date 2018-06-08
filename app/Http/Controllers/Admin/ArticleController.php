<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;

class ArticleController extends Controller
{
    //文章列表页面
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Article::latest('created_at')->Paginate(20);
        return view('admin.articles.index', compact('data'));
    }

    //文章创建页面

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view("admin.articles.create");
    }

    //文章创建

    /**
     *
     */
    public function store(){

    }

    //文章修改页面

    /**
     *
     */
    public function edit($id){
        $data = Article::find($id);
        if(!$data){
            abort(404);
        }
        return view('admin.articles.edit', compact('data'));
    }

    //文章修改

    /**
     *
     */
    public function update(){

    }

    //文章删除

    /**
     *
     */
    public function destroy($id){
        $item = Article::find($id);
        if(!$item){
            abort(404);
        }
        if(!$item->delete()){
            return response()->json(['static'=>'false']);
        }else{
            Comment::where('article_id', '=', $id)->delete();
            return response()->json(['static'=>'true']);
        }
    }

    public function verify(Request $request){
        $id = $request->input('id');
        $verify = $request->input('is_verify');
        $item = Article::find($id);
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
