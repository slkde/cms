<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function index(){
        $data = Comment::latest('created_at')->Paginate(10);
        return view('admin.comments.index', compact('data'));
    }
}
