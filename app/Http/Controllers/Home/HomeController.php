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

class HomeController extends Controller
{
    // 首页
    public function index(){
        // 判断是否为手机用户
        $userAgent  = new Agent();
        $isMobile = $userAgent->isMobile() ? 'Y': 'N';
        // 获取所有信息
        $latestItems = Cache::remember('home_latest_items', 30, function(){
            return Article::where('is_verify', '=', 'Y')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);
        });
        // 获取所有评论
        $comments = Cache::remember('home_latest_comments', 1440, function () {
            return Comment::where('is_verify', '=', 'Y')->latest('created_at')->Paginate(50);
        });
        // $menu = Category::where('pid', 0)->get();
        return view('home.index.index', compact('latestItems', 'comments', 'isMobile'));
    }

    // 分类页面
    public function category($id){
        // 获取分类
        $category =  Category::find($id);
        if(! $category ) {
            abort(404);
        }
        // 导航
        if(!count($category->getparent)){
            $categorys =  $category->getchild;
            $breadcrumb = '<li class="active">'.$category->name.'</li>';
        }else{
            $categorys =  Category::find($category->getparent->id)->getchild;
            $breadcrumb = '<li><a href="/category/'.$category->getparent->id.'">'.$category->getparent->name.'</a></li><li class="active">'.$category->name.'</li>';
        }
        // dd($categorys);
        // $category =  Category::find($id);
        // $categorys =  Category::where('pid', $id)->get();
        $ids = Cache::remember('categoryIds' . $id, 60 * 24 * 365, function () use($id) {
            return Category::getids($id);
        });
        // $ids =  Category::select(DB::raw('GROUP_CONCAT(id) as ids'))->where('pid', $id)->get();
        $items = Cache::remember('article' . $id, 60 * 24, function () use($ids) {
            return Article::wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('category_top_expired', 'desc')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);
        });
        // dd($items);
        // $breadcrumb = '';
        // dd($category->getparent->name);
        $isShowMore = $items->count() < 50 ? false : true;
        return view('home.info.category', compact('menu', 'items', 'category', 'categorys', 'isShowMore', 'breadcrumb'));
    }

    // 载入更多
    public function getinfo(Request $request){
        if($request->input('cid')){
            $ids =  Cache::remember('categoryIds' . $request->input('cid'), 60 * 24 * 365, function (){
                return Category::getids($request->input('cid'));
            });
            $items = Cache::remember('category' . $request->input('cid') .'p'. $request->input('page'), 60 * 24, function () use($ids) {
                return Article::wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('category_top_expired', 'desc')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);
            });
            if (!empty($items)) {
                foreach($items as $item)
                {
                // if(strtotime($item->expired_time) < strtotime("now") && ($item->expired_days !=0)) {
                //     $item->title = "<del>".$item->title."</del>";
                // }
                if($item->tel != null)
                {
                    $mobileIcon = " <i class=\"icon-mobile-phone icon-large pull-right\"></i> ";
                } else {
                    $mobileIcon = "";
                }
                if($item->category_top_expired > now() or $item->index_top_expired > now())
                {
                    $leftIcon = "<span class=\"label label-warning lb-md\">顶</span> ";
                } else {
                    $leftIcon = "<i class=\"icon-caret-right\"></i>  ";
                }
                echo "
                    <a target=\"_blank\" href=\"/info-".$item->id.".html\" class=\"list-group-item\">
                    <h4 class=\"list-group-item-heading\">
                    ".$leftIcon."
                    <span>".str_limit($item->title, 40)."</span> ".$mobileIcon."
                    </h4>
                    <span class=\"list-group-item-text small text-muted\">".str_limit($item->content, 80)."</span><span class=\"pull-right small\">".date('Y-m-d',strtotime($item->created_at))."</span>
                    </a>
                ";
                }
            }
        }else{
            $items = Cache::remember('home_latest_items'. $request->input('page'), 30, function(){
                return Article::where('is_verify', '=', 'Y')->orderBy('category_top_expired', 'desc')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);
            });
            if (!empty($items)) {
                foreach($items as $item)
                {
                if($item->tel != null)
                {
                    $mobileIcon = " <i class=\"icon-angle-right\"></i> ";
                } else {
                    $mobileIcon = "";
                }
                if($item->index_top_expired > now())
                {
                    $leftIcon = "<span class=\"label label-warning lb-md\">顶</span>";
                } else {
                    $leftIcon = "";
                }
                echo "
                    <li class=\"list-group-item\">
                    {$mobileIcon}
                    <strong>
                    {$leftIcon}
                    <a target=\"_blank\" href=\"/info-{$item->id}.html\">{$item->title}</a>
                    </strong>
                    <a target=\"_blank\" class=\"small text-info hidden-xs\" href=\"/category/{$item->category->id}\">{$item->category->name}</a>
                    <span class=\"small text-muted hidden-xs\">{$item->district->name}</span>
                    <span class=\"small text-muted pull-right\"> " . date('Y-m-d',strtotime($item->created_at))  . " </span>
                    </li>
                ";
                }
            }
        }

    }

    //详细信息
    public function info($id, Request $request){
        // $menu = Category::where('pid', 0)->get();
        $item = Article::find($id);
        if(! $item || $item->is_verify == 'N') {
            abort(404);
        }
        //导航栏
        $category = Cache::remember('cat' . $id, 60 * 24 * 365, function () use($item) {
            return Category::find($item->category_id);
        });
        if(!count($category->getparent)){
            $breadcrumb = '<li class="active">'.$category->name.'</li>';
        }else{
            $breadcrumb = '<li><a href="/category/'.$category->getparent->id.'">'.$category->getparent->name.'</a></li><li class="active">'.$category->name.'</li>';
        }
        if(! $request->cookie("hit$id")){
            $item->increment('hits', rand(1, 7));
            \Cookie::queue("hit$id", true, 5);
        }
        //判断过期
        $expireDays = strtotime ('+' . $item->expired_days . ' day', strtotime($item->created_at));
        if($expireDays > time()){
            $item->expireDays = round(($expireDays - time() )/ 86400 ) . '天后过期';
        }else{
            $item->expireDays = '已经过期';
        }
        //当前是否为手机用户
        $userAgent  = new Agent();
        $item['isMobile'] = $userAgent->isMobile() ? 'Y': 'N';
        return view('home.info.detail', compact('item', 'breadcrumb', 'menu'));
    }

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

    //搜索
    public function search($key){
        // $items = Article::where('title', 'like', "%$key%")->orWhere('tel', 'like', "%$key%")->orWhere('linkman', 'like', "%$key%")->Paginate(50);
        $items = Cache::remember('search' . $key, 1440, function () use ($key) {
            return Article::where([['is_verify', '=', 'Y'],['title', 'like', "%$key%"]])->orWhere([['is_verify', '=', 'Y'],['tel', 'like', "%$key%"]])->orWhere([['is_verify', '=', 'Y'],['linkman', 'like', "%$key%"]])->Paginate(100);
        });
        return view('home.index.search', compact('items'));
    }
}
