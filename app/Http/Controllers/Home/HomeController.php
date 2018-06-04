<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Image;
use DB;

class HomeController extends Controller
{
    //
    public function index(){
        // dd(null < now());
        // echo now() == '2018-06-05 16:26:33';die;
        $latestItems = Article::where('is_verify', '=', 'Y')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(20);
        $comments = Comment::latest('created_at')->Paginate(20);
        // $menu = Category::where('pid', 0)->get();
        return view('home.index.index', compact('latestItems', 'comments', 'menu'));
    }


    public function category($id){
        // $menu = Category::where('pid', 0)->get();
        $category =  Category::find($id);
        $ids =  Category::getids($id);
        // $ids =  Category::select(DB::raw('GROUP_CONCAT(id) as ids'))->where('pid', $id)->get();
        // dd($ids);
        $items = Article::wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('category_top_expired', 'desc')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(20);
        // dd($items);
        $breadcrumb = '';
        $categories =  Category::where('pid', $id)->get();
        // dd($category->getparent->name);
        $isShowMore = $items->count() < 50 ? false : true;
        return view('home.info.category', compact('menu', 'items', 'category', 'isShowMore', 'breadcrumb'));
    }

    public function info($id){
        $menu = Category::where('pid', 0)->get();
        $item = Article::find($id);
        // dd($item->comments);
        $breadcrumb = '';
        return view('home.info.detail', compact('item', 'breadcrumb', 'menu'));
    }

    public function about(){
        // $menu = Category::where('pid', 0)->get();
        return view('home.about.index', compact('menu'));
    }

    public function statement(){
        // $menu = Category::where('pid', 0)->get();
        return view('home.about.statement', compact('menu'));
    }
}
