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

Route::get('/', function () {
    return view('welcome');
});
//登陆视图
Route::get("/loginView","CommonController@loginView");
//登陆操作
Route::get('/doLogin','CommonController@doLogin');
//公共视图
Route::get('/commonView','CommonController@commonView');
//首页视图
Route::get('/index','CommonController@indexView');