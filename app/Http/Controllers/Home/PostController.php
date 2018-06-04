<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentRequest;
use Log;
use Agent;
class PostController extends Controller
{
    //
    public function index(){
        session(['time_start' => microtime(true)]);
        // $menu = Category::where('pid', 0)->get();
        return view('home.info.post', compact('menu'));
    }

    public function store(PostRequest $request){
        $agent = new Agent();
        $timeUsed =  microtime(true) - session('time_start');
        if ($timeUsed < 3){
            Log::info("灌水信息:" . var_export($request->all() + ['timeUsed' => $timeUsed] + ['user_agent' => $agent->getUserAgent()] + ['ip'=> $request->ip()], true));
            /** 如果小于五秒，则可能是灌水。 */    
            $request->flash;             
            return redirect()->back();
        }

        $input = $request->except('_token', 'captcha');
        $input['ip'] = $request->ip();
        if(!Article::create($input)){
            $request->flash;
            return redirect()->back();
        }
        return redirect('/info/result')->with('message', '信息提交成功，审核通过后，就会在网站上显示！');
    }

    public function comment(CommentRequest $request){
        $input = $request->except('_token', 'captcha');
        $input['ip'] = $request->ip();
        if(!Comment::create($input)){
            $request->flash;
            return redirect()->back();
        }
        return redirect("/info-".$request->input('article_id').".html/")->with('message' , '留言成功，审核通过后才会在页面显示。');
    }
}
