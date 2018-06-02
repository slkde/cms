<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;

class PostController extends Controller
{
    //
    public function index(){
        $menu = Category::where('pid', 0)->get();
        return view('home.info.post', compact('menu'));
    }
}
