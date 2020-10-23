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

Route::get('/laravel', function () {
    return view('welcome');
});
Route::get("/","Index\IndexController@index");//首页

Route::get("/register","Index\LoginController@reg");//注册
Route::post("/regdo","Index\LoginController@regdo");//进行注册
Route::get('/index/active','Index\LoginController@active');//激活用户

Route::get("/login","Index\LoginController@login");//登录
Route::post("/logindo","Index\LoginController@logindo");//进行登录
Route::get("/logout","Index\LoginController@logout");//退出登录

Route::get("/github/callback","Index\LoginController@github");//github登录


Route::get("/search","Index\IndexController@search");//列表页
Route::any("/goods/{goods_id}","Index\IndexController@goods");//详情页
Route::any("/cart/cartlist/{goods_id}","Index\IndexController@addCart");//加入购物车
Route::any("/cart","Index\CarController@cart");//购物车列表
Route::any("/changeNumber","Index\CarController@changeNumber");//购物车方法


Route::any("/orderInfo","Index\CarController@orderInfo");//结算

Route::get("/test","TestController@test");
Route::get("/test1","TestController@test1");

Route::get("/guzzle","TestController@guzzle");
Route::get("/guzzlepost","TestController@guzzlepost");