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

//雇主管理
Route::get('/employerList','EmployerController@list');//雇主列表
Route::get('/employerAdd','EmployerController@add'); //添加视图
Route::post('/getBigEmployer','EmployerController@getBigEmployer'); //添加外判雇主时获取主雇主数据
Route::post('/employerInsert','EmployerController@insert'); //插入数据
Route::get('/employerEdit','EmployerController@edit'); //修改视图
Route::post('/employerEditInsert','EmployerController@editInsert'); //修改插入数据


