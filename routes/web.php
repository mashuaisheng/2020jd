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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get("/","Index\IndexController@index");//首页
Route::get("/register","Index\LoginController@reg");//注册
Route::get("/login","Index\LoginController@login");//登录

Route::get("/search","Index\IndexController@search");//列表页
Route::get("/item","Index\IndexController@item");//详情页
