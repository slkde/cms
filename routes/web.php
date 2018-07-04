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
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/category/{id}', 'CategoryController@category')->where('id', '[0-9]+')->name('category');
    Route::get('/info-{id}.html', 'InfoController@info')->where('id', '[0-9]+')->name('info');
    Route::get('/about', 'PageController@about')->name('about');
    Route::post('/getinfo', 'CategoryController@getinfo')->name('getinfo');
    Route::get('/statement', 'PageController@statement')->name('statement');
    Route::get('/tp', 'PageController@tp')->name('top');
    Route::get('/search/{key}', 'SearchController@search')->name('search');
    Route::post('/hits', 'PageController@hits')->name('hits');
    Route::resource('/post', 'PostController');
    Route::post('/comment', 'CommentController@comment')->name('comment');
    Route::post('/article/auth', 'InfoController@auth')->name('auth');
    Route::get('/result', 'PageController@result')->name('result');
    Route::post('/getchilds', 'PostController@getChilds')->name('getChilds');
});

//后台页面路由
Route::group(['namespace'=>'Admin', 'prefix'=>'279497165', 'middleware'=>'App\Http\Middleware\CheckAdmin'], function(){
    Route::get('/', 'AdminShowController@index')->name('adminindex');
    Route::resource('/admin', 'AdminController');
    Route::resource('/article', 'ArticleController');
    Route::post('/article/verify', 'ArticleController@verify')->name('articleverify');
    Route::post('/deletePhoto', 'ArticleController@deletePhoto')->name('deletePhoto');
    Route::resource('/comment', 'CommentController');
    Route::post('/comment/verify', 'CommentController@verify')->name('commentverify');
    Route::resource('/config', 'ConfigController');
    Route::resource('/user', 'UserController');
    Route::resource('/profile', 'ProfileController');
    Route::post('/sitemap', 'DashboardController@sitemap')->name('sitemap');
    Route::post('/clearlog', 'DashboardController@clearlog')->name('clearlog');
    Route::post('/clearcache', 'DashboardController@clearcache')->name('clearcache');
    Route::get('/vlog', 'LogController@vlog')->name('vlog');
    Route::get('/weichat', 'LogController@weichat')->name('weichatlog');
});
//后台登陆路由
Route::get('/279497165/login', 'Admin\LoginController@login')->name('adminlogin');
Route::post('/279497165/login', 'Admin\LoginController@dologin')->name('admindologin');
Route::get('/279497165/logout', 'Admin\LoginController@logout')->name('adminlogout');

//微信公众号
Route::any('weichat', 'Weichat\WeichatController@weichat')->name('weichat');