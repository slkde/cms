<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UrlController extends Controller
{
    public function jumpurl($where){
        echo "正在为您跳转......";
        return redirect(base64_decode($where) . '?from=www.ja168.net');
    }
}
