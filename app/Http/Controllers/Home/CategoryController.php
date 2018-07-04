<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Cache;
use DB;

class CategoryController extends Controller
{
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
        $items = Cache::remember('category' . $id, 60 * 24, function () use($ids) {
            return Article::select(DB::raw('id,category_id,district_id,is_mobile,title,created_at,content,ISNULL(index_top_expired) || index_top_expired < now() AS p, ISNULL(category_top_expired) || category_top_expired < now() AS p1'))->wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('p1', 'asc')->orderBy('p', 'asc')->latest('created_at')->Paginate(50);
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
                return Article::select(DB::raw('id,category_id,district_id,is_mobile,title,created_at,content,ISNULL(index_top_expired) || index_top_expired < now() AS p, ISNULL(category_top_expired) || category_top_expired < now() AS p1'))->wherein('category_id', $ids)->where('is_verify', '=', 'Y')->orderBy('p1', 'asc')->orderBy('p', 'asc')->latest('created_at')->Paginate(50);
            });
            if (!empty($items)) {
                foreach($items as $item)
                {
                // if(strtotime($item->expired_time) < strtotime("now") && ($item->expired_days !=0)) {
                //     $item->title = "<del>".$item->title."</del>";
                // }
                if($item->is_mobile == 'Y')
                {
                    $mobileIcon = "<i class='icon-mobile-phone icon-large pull-right'></i>";
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
                return Article::select(DB::raw('id,category_id,district_id,is_mobile,title,created_at,content, (ISNULL(index_top_expired) || index_top_expired < now()) AS p'))->where('is_verify', '=', 'Y')->orderBy('p', 'asc')->latest('created_at')->Paginate(50);
            });
            if (!empty($items)) {
                foreach($items as $item)
                {
                if($item->is_mobile == 'Y')
                {
                    $mobileIcon = "<i class='icon-mobile-phone icon-large'></i>";
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
                    <li class=\"list-group-item\"><i class=\"icon-angle-right\"></i>
                    
                    <strong>
                    {$leftIcon}
                    <a target=\"_blank\" href=\"/info-{$item->id}.html\">{$item->title}</a>
                    </strong>
                    <a target=\"_blank\" class=\"small text-info hidden-xs\" href=\"/category/{$item->category->id}\">{$item->category->name}</a>
                    <span class=\"small text-muted hidden-xs\">{$item->district->name}</span>
                    {$mobileIcon}
                    <span class=\"small text-muted pull-right\"> " . date('Y-m-d',strtotime($item->created_at))  . " </span>
                    </li>
                ";
                }
            }
        }

    }
}
