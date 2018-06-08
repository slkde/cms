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
    Route::resource('/', 'HomeController');
    Route::get('/category/{id}', 'HomeController@category')->where('id', '[0-9]+')->name('category');
    Route::get('/info-{id}.html', 'HomeController@info')->where('id', '[0-9]+')->name('info');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::post('/getinfo', 'HomeController@getinfo')->name('getinfo');
    Route::get('/statement', 'HomeController@statement')->name('statement');
    Route::get('/message', 'HomeController@message')->name('message');
    Route::get('/tp', 'HomeController@tp')->name('tp');
    Route::get('/search/{key}', 'HomeController@search')->name('search');

    Route::resource('/post', 'PostController');
    Route::post('/comment', 'PostController@comment')->name('comment');
    Route::post('/article/auth', 'PostController@auth')->name('auth');
    Route::get('/result', 'PostController@result')->name('result');
});

//后台页面路由
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'middleware'=>'App\Http\Middleware\CheckAdmin'], function(){
    Route::get('/', 'AdminShowController@index')->name('adminindex');
    Route::resource('/admin', 'AdminController');
    Route::resource('/article', 'ArticleController');
    Route::post('/article/verify', 'ArticleController@verify');
    Route::resource('/comment', 'CommentController');
    Route::post('/comment/verify', 'CommentController@verify');
    Route::resource('/config', 'ConfigController');
    Route::resource('/user', 'UserController');
    Route::resource('/profile', 'ProfileController');
});
//后台登陆路由
Route::get('/admin/login', 'Admin\AdminShowController@login')->name('adminlogin');
Route::post('/admin/login', 'Admin\AdminShowController@dologin')->name('admindologin');
Route::get('/admin/logout', 'Admin\AdminShowController@logout')->name('adminlogout');