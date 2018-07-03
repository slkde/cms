<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Cache;


class PageController extends Controller
{
    //关于我们
    public function about(){
        // $menu = Category::where('pid', 0)->get();
        return view('home.about.index', compact('menu'));
    }

    //声明
    public function statement(){
        // $menu = Category::where('pid', 0)->get();
        return view('home.about.statement', compact('menu'));
    }

    //
    public function tp(){
        return view('home.index.msgtop');
    }

    //AJAX获取点击次数
    public function hits(Request $request){
        $id   = $request->input('id');
        $item = Article::find($id);
        if(! $request->cookie("hit$id")){
            $item->increment('hits', rand(1, 7));
            \Cookie::queue("hit$id", true, 5);
        } 
        return $item->hits;
    }

    //
    public function result(){
        if (!session('message'))
        {
          return redirect('/');
        }
        return view('home.info.result', ['message' => session('message')]);
    }
}
