<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\District;
use App\Models\Image;
use Jenssegers\Agent\Agent;
use Cache;
use DB;

class InfoController extends Controller
{
    //详细信息
    public function info($id, Request $request){
        // $menu = Category::where('pid', 0)->get();
        $item = Cache::remember('info' . $id, 60 * 24 * 365, function () use($id) {
            $item = Article::find($id);
            if(! $item || $item['is_verify'] == 'N') {
                abort(404);
            }
            $item = $item->toArray();
            $item['images'] = Image::select('file')->where('article_id', $id)->get()->toArray();
            $item['district'] = District::select('name')->find($item['district_id'])->toArray()['name'];
            return $item;
        });
        // dd($item);
        // if(! $item || $item['is_verify'] == 'N') {
        //     abort(404);
        // }
        //导航栏
        $category =  Category::find($item['category_id']);
        if(!count($category->getparent)){
            $breadcrumb = '<li class="active">'.$category->name.'</li>';
        }else{
            $breadcrumb = '<li><a href="/category/'.$category->getparent->id.'">'.$category->getparent->name.'</a></li><li class="active">'.$category->name.'</li>';
        }
        //判断过期
        $expireDays = strtotime ('+' . $item['expired_days'] . ' day', strtotime($item['created_at']));
        if($expireDays > time()){
            $item['expireDays'] = round(($expireDays - time() )/ 86400 ) . '天后过期';
        }else{
            $item['expireDays'] = '已经过期';
        }
        //当前是否为手机用户
        $userAgent  = new Agent();
        $item['isMobile'] = $userAgent->isMobile() ? 'Y': 'N';
        //信息下所有评论
        $comments = Cache::remember('comments' . $id, 60 * 24 * 365, function () use($id) {
            return Comment::where([['article_id', $id], ['is_verify','Y']])->orderby('created_at')->get()->toArray();
        });
        // dd($comments);
        return view('home.info.detail', compact('item', 'breadcrumb', 'comments'));
    }

    //验证修改信息密码
    public function auth(Request $request){
        $input = $request->except('_token');
        $id = $input['id'];
        // 获取对象
        $item = Article::where('id', $id)->where('manage_passwd', $input['password'])->get()->first();
        if(!$item){
            return redirect()->back()->with('msgAuth' , '密码错误！');
        }
        //验证成功保存到SESSION
        $request->session()->put("auth.$id", true);
        return redirect()->back();
    }
}
