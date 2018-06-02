<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Image;

class Homecontroller extends Controller
{
    //
    public function index(){
        $latestItems = Article::latest('created_at')->Paginate(20);
        $comments = Comment::latest('created_at')->Paginate(20);
        $menu = Category::where('pid', 0)->get();
        return view('home.index.index', compact('latestItems', 'comments', 'menu'));
    }

    public function category($id){
        $menu = Category::where('pid', 0)->get();
        $items = Article::where('category_id', $id)->latest('created_at')->Paginate(20);
        $categories =  Category::where('pid', $id)->get();
        $infoCat =  Category::find($id);
        $breadcrumb = '';
        // dd($infoCat->getparent()->name);
        $isShowMore = $items->count() < 50 ? false : true;
        return view('home.info.category', compact('menu', 'items', 'infoCat', 'isShowMore', 'categories', 'breadcrumb'));
    }

    public function info($id){
        $menu = Category::where('pid', 0)->get();
        $item = Article::find($id);
        $breadcrumb = '';
        $captchaImage = '';
        return view('home.info.detail', compact('item', 'breadcrumb', 'captchaImage', 'menu'));
    }

    public function about(){
        $menu = Category::where('pid', 0)->get();
        return view('home.about.index', compact('menu'));
    }

    public function statement(){
        $menu = Category::where('pid', 0)->get();
        return view('home.about.statement', compact('menu'));
    }
}
