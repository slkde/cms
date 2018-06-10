<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;
class LogController extends Controller
{
    //
    public function vlog(){
        $logs = file_get_contents(base_path() . '/storage/logs/laravel.log');
        // dd($logs);
        return view('admin.log.index', compact('logs'));
    }
}
