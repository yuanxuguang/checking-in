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
Route::get('/setDistance','CommonController@setDistance');
Route::get('/updateDistance','CommonController@updateDistance');
//首页视图
Route::get('/index','CommonController@indexView');

//雇主管理
Route::get('/employerList','EmployerController@list');//雇主列表
Route::get('/employerInfo','EmployerController@employerInfo');//个人信息
Route::post('/setEmployerStatus','EmployerController@setEmployerStatus'); //封号 解封操作
Route::get('/employerAdd','EmployerController@add'); //添加视图
Route::post('/getBigEmployer','EmployerController@getBigEmployer'); //添加外判雇主时获取主雇主数据
Route::post('/employerInsert','EmployerController@insert'); //插入数据
Route::get('/employerEdit/{id}','EmployerController@edit'); //修改视图
Route::post('/editInsert','EmployerController@editInsert'); //修改插入数据

//合约管理
Route::get('/contractList','ContractController@list'); //合约列表
Route::get('/contractAdd','ContractController@add'); //添加页面
Route::post('/contractInsert','ContractController@insert'); //添加数据操作
Route::get('/contractEdit/{cid}','ContractController@edit'); //修改界面
Route::post('/contractEditInsert','ContractController@editInsert'); //修改插入
Route::get('/contractDelete','ContractController@delete'); //删除合约

//学校管理
Route::get('/schoolList','SchoolController@list'); //学校列表
Route::get('/schoolAdd','SchoolController@add'); //添加页面
Route::post('/schoolInsert','SchoolController@insert'); //添加数据操作
Route::get('/schoolEdit/{cid}','SchoolController@edit'); //修改界面
Route::post('/schoolEditInsert','SchoolController@editInsert'); //修改插入
Route::get('/schoolDelete','SchoolController@delete'); //删除
Route::post('/excelImport','SchoolController@excelImport');//导入excel

//职位管理
Route::get('/jobList','JobController@list'); //职位列表
Route::get('/jobAdd','JobController@add'); //添加页面
Route::post('/jobInsert','JobController@insert'); //添加数据操作
Route::get('/jobEdit/{cid}','JobController@edit'); //修改界面
Route::post('/jobEditInsert','JobController@editInsert'); //修改插入
Route::get('/jobDelete','JobController@delete'); //删除

//员工管理
Route::get('/staffList','StaffController@list'); //员工列表
Route::get('/staffAdd','StaffController@add'); //添加页面
Route::post('/staffInsert','StaffController@insert'); //添加数据操作
Route::get('/staffEdit/{cid}','StaffController@edit'); //修改界面
Route::post('/staffEditInsert','StaffController@editInsert'); //修改插入
Route::get('/staffDelete','StaffController@delete'); //删除
Route::get('/setStaffStatus','StaffController@setStaffStatus'); //更改状态
Route::get('/staffOutEmployer/{sid}/{eid}','StaffController@staffOutEmployer'); //更改状态

//标签管理
Route::get('/labelList','LabelController@list'); //列表
Route::get('/labelAdd','LabelController@add'); //添加页面
Route::post('/labelInsert','LabelController@insert'); //添加数据操作
Route::get('/labelEdit/{lid}','LabelController@edit'); //修改界面
Route::post('/labelEditInsert','LabelController@editInsert'); //修改插入
Route::get('/labelDelete','LabelController@delete'); //删除合约
Route::get('/getLevel2Label','LabelController@getLevel2Label');

//考勤
Route::get('/clockList','ClockController@list');//列表
Route::get('/video','ClockController@video');//打卡视频
});

//API
Route::post('/registerStaff','ApiController@registerStaff');
//员工端
Route::get('/getEmployer','ApiController@getEmployer');//员工注册-模糊搜索获取雇主
Route::get('/getJob','ApiController@getJob');//员工注册-获取雇主创建的职位
Route::post('/apiLogin','ApiController@login'); //登陆
Route::post('/apiPwdVerify','ApiController@apiPwdVerify');//密码验证
Route::post('/apiClockCamera','ApiController@apiClockCamera');//上班打卡-摄像
Route::post('/clockFace','ApiController@clockFace');//上班打卡-人脸
Route::post('/officeClockOut','ApiController@officeClockOut');//上班-下班打卡
Route::post('/clockRecord','ApiController@clockRecord');//打卡记录
Route::post('/stationClock','ApiController@stationClock');//上班打卡-工位打卡

//管理端
Route::post('/indexing','ApiController@indexing');//打卡记录
