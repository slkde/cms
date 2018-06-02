<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
class AdminRepository
{
    public function dashboard_init_data()
    {
        return $collects = collect(
            [
                [
                    'count' => User::count(),
                    'title' => '用户',
                    'sup' => '人',
                    'icon' => 'ion-person-add',
                    'bck' => 'bg-aqua',
                    'url' => '/admin/user'
                ],
                
                [
                    'count' => Article::count(),
                    'title' => '信息',
                    'sup' => '篇',
                    'icon' => 'ion-document',
                    'bck' => 'bg-green',
                    'url' => '/admin/article'
                ],
                [
                    'count' => Comment::count(),
                    'title' => '评论',
                    'sup' => '条',
                    'icon' => 'ion-android-chat',
                    'bck' => 'bg-red',
                    'url' => 'admin/comment'
                ],
                // [
                //     'count' => 86,
                //     'title' => '视频',
                //     'sup' => '个',
                //     'icon' => 'ion-videocamera',
                //     'bck' => 'bg-purple',
                //     'url' => 'admin/video/index'
                // ]
            ]
        );
    }
}