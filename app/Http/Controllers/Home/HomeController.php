<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Image;
use Jenssegers\Agent\Agent;
use Cache;
use DB;

class HomeController extends Controller
{
    // 首页
    public function index(){
        // 判断是否为手机用户
        $userAgent  = new Agent();
        $isMobile = $userAgent->isMobile() ? 'Y': 'N';
        // 获取所有信息
        $latestItems = Cache::remember('home_latest_items', 30, function(){
            return Article::select(DB::raw('*, (ISNULL(index_top_expired) || index_top_expired < now()) AS p'))->where('is_verify', '=', 'Y')->orderBy('p', 'asc')->latest('created_at')->Paginate(50);
        });
        // 获取所有评论
        $comments = Cache::remember('home_latest_comments', 1440, function () {
            return Comment::where('is_verify', '=', 'Y')->latest('created_at')->Paginate(50);
        });
        $blog_articles = DB::connection('blog')->select("SELECT id,post_title FROM `wp_posts` WHERE post_status=\"publish\" AND post_type=\"post\" ORDER BY id DESC");
        // $menu = Category::where('pid', 0)->get();
        return view('home.index.index', compact('latestItems', 'comments', 'isMobile', 'blog_articles'));
    }
 
}
