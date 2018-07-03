<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Cache;

class SearchController extends Controller
{
    //搜索
    public function search($key){
        // $items = Article::where('title', 'like', "%$key%")->orWhere('tel', 'like', "%$key%")->orWhere('linkman', 'like', "%$key%")->Paginate(50);
        $items = Cache::remember('search' . $key, 1440, function () use ($key) {
            return Article::where([['is_verify', '=', 'Y'],['title', 'like', "%$key%"]])->orWhere([['is_verify', '=', 'Y'],['tel', 'like', "%$key%"]])->orWhere([['is_verify', '=', 'Y'],['linkman', 'like', "%$key%"]])->Paginate(100);
        });
        return view('home.index.search', compact('items'));
    }
}
