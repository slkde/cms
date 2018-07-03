<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    //提交评论
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

}
