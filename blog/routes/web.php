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
Route::get('/map',function(){ return view('contract.map'); }); //地图
//登陆视图
Route::get("/loginView","CommonController@loginView");
//登陆操作
Route::post('/doLogin','CommonController@doLogin');
//退出登陆
Route::get('/loginOut','CommonController@loginOut');

//登陆中间件组
Route::group(['middleware' => ['login']],function(){

//公共视图
Route::get('/commonView','CommonController@commonView');
//首页视图
Route::get('/index','CommonController@indexView');

//雇主管理
Route::get('/employerList','EmployerController@list');//雇主列表
Route::post('/setEmployerStatus','EmployerController@setEmployerStatus'); //封号 解封操作
Route::get('/employerAdd','EmployerController@add'); //添加视图
Route::post('/getBigEmployer','EmployerController@getBigEmployer'); //添加外判雇主时获取主雇主数据
Route::post('/employerInsert','EmployerController@insert'); //插入数据
Route::get('/employerEdit/{id}','EmployerController@edit'); //修改视图
Route::post('/editInsert','EmployerController@editInsert'); //修改插入数据

//合约管理
Route::get('/contractList','ContractController@list'); //合约列表

Route::get('/contractAdd','ContractController@add'); //合约列表
Route::post('/contractInsert','ContractController@insert'); //合约列表
Route::get('/contractEdit','ContractController@edit'); //合约列表
Route::post('/contractEditInsert','ContractController@editInsert'); //合约列表
Route::get('/contractDelete','ContractController@delete'); //合约列表

});