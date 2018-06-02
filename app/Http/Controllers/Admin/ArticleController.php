<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    //文章列表页面
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Article::latest('created_at')->Paginate(10);
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
    public function destroy(){

    }
}
