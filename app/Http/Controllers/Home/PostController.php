<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\CommentRequest;
use Log;
use Jenssegers\Agent\Agent;
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

        foreach($input as $v){
            if(empty($input[$v])){
                unset($input[$v]);
            }
        }
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

    public function auth(Request $request){
        $input = $request->except('_token');
        $id = $input['id'];
        // dd($input->id);
        $item = Article::find($input['id'])->where('manage_passwd', $input['password'])->get()->first();
        if(!$item){
            return redirect()->back()->with('msgAuth' , '密码错误！');
        }
        $request->session()->put("auth . $id");
        return redirect()->back();
    }

    public function edit($id){
        if(! session("auth$id")) {
            return redirect('/message')->with('message', '您无权访问该页面！');
        }
        $item = Article::find($id);
        // dd($item);
        return view('home.info.edit', compact('item'));
    }

    public function update($id, PostEditRequest $request){
        $input = $request->except('_token', '_method','captcha');
        $input['id'] = $id;
        $input['is_verify'] = 'N';
        // dd($input);
        if(! session("auth$id")) {
            return redirect('/message')->with('message', '您无权访问该页面！');
        }
        $item = Article::find($id);

        foreach($input as $v){
            if(empty($input[$v])){
                unset($input[$v]);
            }
        }
        if(! $item->update($input)){
            return redirect('/post/result')->with('message', '未知错误！');
        }
        return redirect('/post/result')->with('message', '信息保存成功，管理员审核通过后，就会在网站上显示！');
    }
}
