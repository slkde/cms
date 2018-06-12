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
use Jenssegers\Agent\Agent;
use Log;
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
        $input = $request->except('_token', 'captcha', 'images');
        $input['ip'] = $request->ip();
        $input['is_mobile'] = $agent->isMobile() ? 'Y' : 'N';
        //判断灌水并存入日志
        if ($timeUsed < 3){
            Log::info("灌水信息:" . var_export( $input + ['timeUsed' => $timeUsed] + ['user_agent' => $agent->getUserAgent()] , true));
            /** 如果小于五秒，则可能是灌水。 */    
            $request->flash();             
            return redirect()->back();
        }
        //剔除空键
        foreach($input as $k=>$v){
            if(empty($input[$k])){
                unset($input[$k]);
            }
        }
        $input['title'] = strip_tags($input['title']);
        $input['content'] = strip_tags($input['content']);
        //保存
        $art = Article::create($input);
        if(!$art){
            $request->flash();
            return redirect()->back();
        }
        //上传图片
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
        
        return redirect()->route('result')->with('message', '信息提交成功，审核通过后，就会在网站上显示！');
    }

    public function comment(CommentRequest $request){
        $input = $request->except('_token', 'captcha');
        $input['ip'] = $request->ip();
        $input['content'] = strip_tags($input['content']);
        //保存评论
        if(!Comment::create($input)){
            $request->flash();
            return redirect()->back();
        }
        return redirect("/info-".$request->input('article_id').".html/")->with('message' , '留言成功，审核通过后才会在页面显示。');
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
    //编辑信息
    public function edit($id){
        if(! session("auth.$id")) {
            return redirect('/message')->with('message', '您无权访问该页面！');
        }
        $item = Article::find($id);
        // dd($item);
        return view('home.info.edit', compact('item'));
    }
    //更新信息
    public function update($id, PostEditRequest $request){
        $input = $request->except('_token', '_method','captcha', 'images');
        // $input['id'] = $id;
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
        //上传图片
        if ($request->hasFile('images')) {
            $path =  '/upload/images/' . date('Y') . '/' . date('m') . '/';
            foreach($request->file('images') as $image) {
                $file = date('mdHis') . rand('1000','9999') . '.' .  $image->extension();
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

    public function getChilds(Request $request){
        $id = $request->input('id'); 
        $item = Category::where('pid', $id)->get();
        return response()->json($item->toArray());
    }
}
