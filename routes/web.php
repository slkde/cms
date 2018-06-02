<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//前台页面路由
Route::group(['namespace'=>'Home'], function(){
    Route::get('/', 'HomeController@index');
    Route::get('/category/{id}', 'HomeController@category')->where('id', '[0-9]+');
    Route::get('/info-{id}.html', 'HomeController@info')->where('id', '[0-9]+');
    Route::resource('/post', 'PostController');
    Route::get('/about', 'HomeController@about');
    Route::get('/statement', 'HomeController@statement');
});

//后台页面路由
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'middleware'=>'App\Http\Middleware\CheckAdmin'], function(){
    Route::resource('/', 'AdminShowController');
    Route::resource('/admin', 'AdminController');
    Route::resource('/user', 'UserController');
    Route::resource('/article', 'ArticleController');
    Route::resource('/comment', 'CommentController');
    Route::resource('/config', 'ConfigController');
});
//后台登陆路由
Route::get('/admin/login', 'Admin\AdminShowController@login');
Route::post('/admin/login', 'Admin\AdminShowController@dologin');
Route::get('/admin/logout', 'Admin\AdminShowController@logout');