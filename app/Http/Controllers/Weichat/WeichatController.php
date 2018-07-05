<?php

namespace App\Http\Controllers\Weichat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat\Kernel\Messages\Text;
use App\Models\Article;
use Cache;

class WeichatController extends Controller
{
    //
    public function weichat(){
        Log::info('request arrived.');
        $app = app('wechat.official_account');
        $app->server->push(function($message){
            switch ($message['MsgType']) {
                case 'event':
                    return '欢迎关注集安信息网';
                    break;
                case 'text':
                    if ($message['FromUserName'] == 'oPoOQwTaaB4I9vn4qwcHnHVPxVHQ' || $message['FromUserName'] == 'oPoOQwfDJXApK8VQS2HNx5GtA8CM'){
                        $msg = explode('@', $message['Content']);
                        switch ($msg['0']) {
                            case '未审核':
                                $data = Article::where('is_verify', '=', 'N')->count();
                                if(!$data){
                                    return '没有未审核信息';
                                }
                                return '未审核信息'.$data.'条！';
                                break;
                            case '审核':
                                $item = Article::find($msg['1']);
                                if(! $item){
                                    return '信息不存在！';
                                }
                                $item->update(['is_verify' => 'Y']);
                                return '审核<'. $msg['1'] .'>成功！';
                                break;
                            case '取消审核':
                                $item = Article::find($msg['1']);
                                if(! $item){
                                    return '信息不存在！';
                                }
                                $item->update(['is_verify' => 'N']);
                                return '取消审核<'. $msg['1'] .'>成功！';
                                break;
                            case '清空缓存':
                                Cache::flush();
                                return '清空缓存成功！';
                                break;
                        }
                    }
                    return 'http://www.ja168.net';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        return $app->server->serve();
    }
}
