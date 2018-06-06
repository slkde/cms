<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Image;
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

        $input = $request->except('_token', 'captcha', 'images');
        $input['ip'] = $request->ip();
        $input['is_mobile'] = $agent->isMobile() ? 'Y' : 'N';
        foreach($input as $k=>$v){
            if(empty($input[$k])){
                unset($input[$k]);
            }
        }
        $art = Article::create($input);
        if(!$art){
            $request->flash;
            return redirect()->back();
        }

        if ($request->hasFile('images')) {
            $path =  '/upload/images/' . date('Y') . '/' . date('m') . '/';
            foreach($request->file('images') as $image) {
                $file = date('dHis') . rand('1000','9999') . '.' .  $image->extension();
                if($image->move(public_path() . $path, $file)){
                    $img['article_id'] = $art->id;
                    $img['file'] = $path . $file;
                    $img['size'] = round($image->getClientSize() / 1024);
                    Image::create($img);
                }
            }
        }
        \Cookie::queue("hit$art->id", true, 5);
        return redirect()->route('result')->with('message', '信息提交成功，审核通过后，就会在网站上显示！');
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
        // dd($id);
        // dd(session());
        // $item = Article::find($input['id'])->where('manage_passwd', $input['password'])->get()->first();
        $item = Article::where('id', $id)->where('manage_passwd', $input['password'])->get()->first();
        if(!$item){
            return redirect()->back()->with('msgAuth' , '密码错误！');
        }
        $request->session()->put("auth.$id", true);
        // dd($request->session());
        // echo $request->session()->get("auth". $id);die;
        // Session::get("auth". $id);die;
        return redirect()->back();
    }

    public function edit($id){
        if(! session("auth.$id")) {
            return redirect('/message')->with('message', '您无权访问该页面！');
        }
        $item = Article::find($id);
        // dd($item);
        return view('home.info.edit', compact('item'));
    }

    public function update($id, PostEditRequest $request){
        $input = $request->except('_token', '_method','captcha', 'images');
        $input['id'] = $id;
        $input['is_verify'] = 'N';
        // dd($input);
        if(! session("auth.$id")) {
            return redirect('/message')->with('message', '您无权访问该页面！');
        }
        $item = Article::find($id);

        foreach($input as $k=>$v){
            if(empty($input[$k])){
                unset($input[$k]);
            }
        }
        if(! $item->update($input)){
            return redirect('/result')->with('message', '未知错误！');
        }

        if ($request->hasFile('images')) {
            $path =  '/upload/images/' . date('Y') . '/' . date('m') . '/';
            foreach($request->file('images') as $image) {
                $file = date('dHis') . rand('1000','9999') . '.' .  $image->extension();
                if($image->move(public_path() . $path, $file)){
                    $img['article_id'] = $id;
                    $img['file'] = $path . $file;
                    $img['size'] = round($image->getClientSize() / 1024);
                    Image::create($img);
                }
            }
        }

        return redirect('/result')->with('message', '信息保存成功，管理员审核通过后，就会在网站上显示！');
    }


    public function destroy($id,Request $request){
        // dd($request->input('id'));
        // dd($request->session());
        if(! \Session::has("auth.$id") ) {
            return ['message', '您无权访问该页面！'];
        }
        $item = Image::find($request->input('id'));
        // dd($item);
        @unlink(public_path() . $item->file);
        if($item->delete()){
            return $request->input('id');
        }
    }

    public function result(){
        if (!session('message'))
        {
          return redirect('/');
        }
        return view('home.info.result', ['message' => session('message')]);
    }
}
