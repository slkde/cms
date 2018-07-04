<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Image;
use Cache;
class ArticleController extends Controller
{
    //文章列表页面
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $s = $request->input('search');
        if($s){
            if(is_numeric($s))
            {//按电话查找
                $data = Article::where('tel','=', trim($s))->latest('created_at')->Paginate(20);
            } elseif($s == 'N') {//按词查找
                $data = Article::where('is_verify','=', 'N')->latest('created_at')->Paginate(20);
            } else {
                $data = Article::where('title','like', trim('%'. $s. '%'))->latest('created_at')->Paginate(20);
            }
        }else{
            $data = Article::latest('created_at')->Paginate(20);
        }
        return view('admin.articles.index', compact('data','s'));
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
        $item = Article::find($id);
        if(!$item){
            abort(404);
        }
        return view('admin.articles.edit', compact('item'));
    }

    //文章修改

    /**
     *
     */
    public function update($id, Request $request){
        $input = $request->except('_token', '_method', 'images');
        // dd($input);
        foreach($input as $k=>$v){
            if(empty($input[$k])){
                unset($input[$k]);
            }
        }
        $item = Article::find($id);
        if(! $item->update($input)){
            return redirect()->back()->with('message', '未知错误！');
        }

        if ($request->hasFile('images')) {
            $path =  '/upload/images/' . date('Y') . '/' . date('m') . '/';
            foreach($request->file('images') as $image) {
                $file = date('dHis') . rand('1000','9999') . '.' .  $image->extension();
                if($image->move(public_path() . $path, $file)){
                    $img['article_id'] = $id;
                    $img['file'] = $path . $file;
                    $img['size'] = round($image->getClientSize() / 1024);
                    Image::create($img);
                }
            }
        }
        Cache::forget('info' . $id);
        return redirect('/279497165/article');
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
            $img = Image::where('article_id', '=', $id)->get();
            if($img){
                foreach($img as $v){
                    @unlink(public_path() . $v->file);
                }
            }
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

    public function deletePhoto(Request $request){
        $item = Image::find($request->input('id'));
        $file = public_path() . $item->file;
        if(!$item){
            abort(404);
        }
        if(!$item->delete()){
            return ;
        }
        @unlink($file);
        return response()->json(['static'=>true]);
    }

}
