<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/admin', 'HomeController@index')->name('home');
    $router->resource('/users', UserController::class);
    $router->resource('/auth/goods', GoodsController::class);
    $router->resource('/auth/category', CategoryController::class);   //分类管理
    $router->resource('/auth/users', UsersController::class);
});
