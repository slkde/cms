<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Image;

class HomeController extends Controller
{
    //首页
    public function index(){
        // dd(null < now());
        // echo now() == '2018-06-05 16:26:33';die;
        $latestItems = Article::where('is_verify', '=', 'Y')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);
        $comments = Comment::latest('created_at')->Paginate(50);
        // $menu = Category::where('pid', 0)->get();
        return view('home.index.index', compact('latestItems', 'comments', 'menu'));
    }

    //分类页面
    public function category($id){
        // $menu = Category::where('pid', 0)->get();
        $category =  Category::find($id);
        // $category =  Category::where('pid', $id)->get();
        $ids =  Category::getids($id);
        // $ids =  Category::select(DB::raw('GROUP_CONCAT(id) as ids'))->where('pid', $id)->get();
        // dd($ids);
        $items = Article::wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('category_top_expired', 'desc')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);
        // dd($items);
        $breadcrumb = '';
        // dd($category->getparent->name);
        $isShowMore = $items->count() < 1 ? false : true;
        return view('home.info.category', compact('menu', 'items', 'category', 'isShowMore', 'breadcrumb'));
    }

    //载入更多
    public function getinfo(Request $request){
        $ids =  Category::getids($request->input('cid'));
        $items = Article::wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('category_top_expired', 'desc')->orderBy('index_top_expired', 'desc')->latest('created_at')->Paginate(50);

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
    }


    public function info($id){
        // $menu = Category::where('pid', 0)->get();
        $item = Article::find($id);
        // dd($item->comments);
        $breadcrumb = '';
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
}
