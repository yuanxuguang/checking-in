<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Storage;
class ApiController extends Controller
{
    //员工注册-模糊搜索获取雇主
    public function getEmployer(){
        $employer = DB::table('employer')
                    ->where('company_num','like','%'.request('condition').'%')
                    ->select('id','name')
                    ->get();
        if($employer->isEmpty()){
            $message = '数据为空';
            $code = 200;
            $data = [];
        }elseif(!$employer->isEmpty()){
            $message = 'success';
            $code = 200;
            $data = $employer;
        }else{
            $message = 'error';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //根据雇主获取职位
    public function getJob(){
        $jobs = DB::table('job')->where('eid',request('eid'))->select('id','j_type','j_name','j_name_en')->get();
        if($jobs->isEmpty()){
            $message = '数据为空';
            $code = 200;
            $data = [];
        }elseif(!$jobs->isEmpty()){
            $message = 'success';
            $code = 200;
            $data = $jobs;
        }else{
            $message = 'error';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //员工注册
    public function registerStaff(){
        $validator = Validator::make(request()->all(),[
            'eid' => 'required',
            'company_num' => 'required',
            'country_type' => 'required',
            'phone_num' => 'required',
            'sex' => 'required',
            'name1' => 'required',
            'name2' => 'required',
            's_type' => 'required',
            'email' => 'required',
            'password' => 'required',
            'safety_problem1' => 'required',
            'safety_problem2' => 'required',
            'face_img' => 'required',
            'safety_problem3' => 'required',
            'j_id' => 'required',
            'technical_merit' => 'required',
            ]);
        $data = request()->all();
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        if(request()->hasFile('face_img')){
            $face_img_path = Storage::putFileAs('/public/c_face_img',request('face_img'),date('Ymd').'_'.date('His').'.png');
            $face_img_path = str_replace('public','/storage',$face_img_path);
            $data['face_img'] = $face_img_path;
        }
        if(request()->hasFile('work_card_front')){
            $work_card_front_path = Storage::putFileAs('/public/c_work',request('work_card_front'),date('Ymd').'_'.date('His').'.png');
            $work_card_front_path = str_replace('public','/storage',$work_card_front_path);
            $data['work_card_front'] = $work_card_front_path;
        }
        if(request()->hasFile('work_card_reverse')){
            $work_card_reverse_path = Storage::putFileAs('/public/c_work',request('work_card_reverse'),date('Ymd').'_'.date('His').'.png');
            $work_card_reverse_path = str_replace('public','/storage',$work_card_reverse_path);
            $data['work_card_reverse'] = $work_card_reverse_path;
        }
        if(request()->hasFile('safety_card_front')){
            $safety_card_front_path = Storage::putFileAs('/public/c_safety',request('safety_card_front'),date('Ymd').'_'.date('His').'.png');
            $safety_card_front_path = str_replace('public','/storage',$safety_card_front_path);
            $data['safety_card_front'] = $safety_card_front_path;
        }
        if(request()->hasFile('safety_card_reverse')){
            $safety_card_reverse_path = Storage::putFileAs('/public/c_safety',request('safety_card_reverse'),date('Ymd').'_'.date('His').'.png');
            $safety_card_reverse_path = str_replace('public','/storage',$safety_card_reverse_path);
            $data['safety_card_reverse'] = $safety_card_reverse_path;
        }

        $data['password'] = md5(request('password'));
        $data['status'] = '0';
        $bool = DB::table('staff')->insert($data);
        if($bool){
            $message = 'success';
            $code = 200;
            $data = [];
        }else{
            $message = 'error';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //登陆
    public function login(){
        $validator = Validator::make(request()->all(),[
            'company_num' => 'required',
            'phone' => 'required',
            'verify_code' => 'required'
        ],[
            'company_num.required' => '公司编号不能为空',
            'phone.required' => '手机号不能为空',
            'verify_code.required' => '验证码不能为空'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $staff = DB::table('staff')->where('company_num',request('company_num'))->first();
        if(!$staff){
            $message = '公司编号不存在';
            $code = 400;
            $data = [];
        }else{
            if($staff->phone_num != request('phone')){
                $message = '手机号错误';
                $code = 400;
                $data = [];
            }else{
                if(request('verify_code') == '123456'){
                    $message = '登陆成功';
                    $code = 200;
                    $data = [];
                }else{
                    $message = '验证码失败';
                    $code = 400;
                    $data = [];
                }
            }
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //密码验证
    public function apiPwdVerify(){
        $validator = Validator::make(request()->all(),[
            'company_num' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ],[
            'company_num.required' => '公司编号不能为空',
            'phone.required' => '手机号不能为空',
            'password.required' => '密码不能为空'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $staff = DB::table('staff')->where('company_num',request('company_num'))->select('id','eid','c_id','sex','password','phone_num','name','ID_card','role','status','clock_type','j_id')->first();
        if(!$staff){
            $message = '公司编号不存在';
            $code = 400;
            $data = [];
        }else{
            if($staff->phone_num != request('phone')){
                $message = '手机号错误';
                $code = 400;
                $data = [];
            }else{
                if(md5(request('password')) == $staff->password){
                    $message = '验证成功';
                    $code = 200;
                    unset($staff->password);
                    $data = $staff;
                }else{
                    $message = '密码错误';
                    $code = 400;
                    $data = [];
                }
            }
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //上班打卡-摄像
    public function apiClockCamera(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required',
            'video' => 'required',
            'eid' => 'required',
            'coordinate' => 'required'
        ],[
            'sid.required' => '员工id不能为空',
            'video.required' => '摄像记录不能为空',
            'eid.required' => 'eid不能为空',
            'coordinate.required' => '坐标不能为空'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data = request()->all();
        $data['start_time'] = date('Y-m-d H:i:s',time());
        $data['date'] = date('Y-m-d',time());
        $data['type'] = '1';
        if(request()->hasFile('video')){
            $path = Storage::putFileAs('/public/c_video',request('video'),date('Ymd').'_'.date('His').'.mp4');
            $path = str_replace('public','storage',$path);
            $data['video'] = $path;
        }
        $bool = DB::table('clock')->insert($data);
        if($bool){
            $message = '打卡成功';
            $code = 200;
            $data = [];
        }else{
            $message = '打卡失败';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //工位扫描- 工位打卡
    public function stationClock(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required',
            'eid' => 'required',
            'coordinate' => 'required',
            'code_GPS' => 'required'
        ],[
            'sid.required' => '员工id不能为空',
            'eid.required' => 'eid不能为空',
            'coordinate.required' => '坐标不能为空'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }

        //判断打卡地点与当前地点的距离
        $distance = $this->get_distance(request('coordinate'),request('code_GPS'));
        $setDistance = DB::table('distance')->where('eid',request('eid'))->first();

        if($distance > $setDistance->work_distance){
            $json['message'] = '与打卡地点相距太远';
            $json['code'] = 200;
            $json['data'] = [];
            return json_encode($json,true);
        }
        $data = request()->all();
        $data['start_time'] = date('Y-m-d H:i:s',time());
        $data['date'] = date('Y-m-d',time());
        $data['type'] = '2';
        unset($data['code_GPS']);
        $bool = DB::table('clock')->insert($data);
        if($bool){
            $message = '打卡成功';
            $code = 200;
            $data = [];
        }else{
            $message = '打卡失败';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //下班打卡
    public function officeClockOut(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required',
        ],[
            'sid.required' => '员工id不能为空',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $s_time = strtotime(date('Y-m-d'),time());
        $e_time = $s_time+86400;
        $end_time = date('Y-m-d H:i:s',time());
        $is_clock = DB::table('clock')->where('sid',request('sid'))->where('start_time','>',date('Y-m-d',$s_time))->where('end_time',NULL)->count();
        if($is_clock){
            $bool = DB::table('clock')->where('sid',request('sid'))->where('start_time','>',date('Y-m-d',$s_time))->where('end_time',NULL)->update(['end_time'=>$end_time]);
            if($bool){
                $message = '下班打卡成功';
                $code = 200;
                $data = [];
            }else{
                $message = '打卡失败';
                $code = 400;
                $data = [];
            }
        }else{
            $message = '今天没有该员工打卡记录';
            $code = 400;
            $data = [];
        }

        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    //打卡记录
    public function clockRecord(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required|numeric',
            'start_time' => 'required|numeric',
            'end_time' => 'required|numeric',
            'page' => 'required|numeric',
            'number' => 'required|numeric'
        ],[
            'sid.required' => '员工id不能为空',
            'start_time.required' => '开始时间不能为空',
            'end_time.required' => '结束时间不能为空',
            'page.required' => '页数不能为空',
            'number' => 'number不能为空'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
//       $page = 0;
//       $numer = 5;
        $s_time = date('Y-m-d',request('start_time'));
        $e_time = date('Y-m-d',request('end_time'));
        $total = DB::table('clock')->where('sid',request('sid'))->where('date','>=',$s_time)->where('date','<',$e_time)->count();
        $totalPage = ceil($total/request('number'));

        $recordList = DB::table('clock')
            ->where('sid',request('sid'))
            ->where('date','>=',$s_time)
            ->where('date','<',$e_time)
            ->select('id','date','start_time','end_time')
            ->offset(request('number')*request('page'))
            ->orderBy('date','desc')
            ->limit(request('number'))
            ->get();
        if(!$recordList->isEmpty()){
            $message = 'ok';
            $code = 200;
            $data = $recordList;
        }elseif($recordList->isEmpty()){
            $message = '没有数据';
            $code = 200;
            $data = [];
        }else{
            $message = 'error';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['totalPage'] = $totalPage;
        $json['number'] = request('number');
        $json['page'] = request('page');
        $json['data'] = $data;
        return json_encode($json,true);
    }


    //管理端api
    //确认合约
    public function confirmContract(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required|numeric',
            'eid' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $contracts = DB::table('contract')->where('eid',request('eid'))->get();
    }

    //获取索引
    public function indexing(){
        $validator = Validator::make(request()->all(),[
            'eid' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $indexing = DB::table('label')->where('l_type',2)->where('eid',request('eid'))->select('id','eid','l_name','level','up_label')->get();
        if(!$indexing->isEmpty()){
            $message = 'ok';
            $code = 200;
            $data = $indexing;
        }elseif($indexing->isEmpty()){
            $message = '没有数据';
            $code = 200;
            $data = [];
        }else{
            $message = 'error';
            $code = 400;
            $data = [];
        }
        $json['message'] = $message;
        $json['code'] = $code;
        $json['data'] = $data;
        return json_encode($json,true);
    }

    /**
     * 根据起点坐标和终点坐标测距离
     * @param  [array]   $from  [起点坐标(经纬度),例如:array(118.012951,36.810024)]
     * @param  [array]   $to    [终点坐标(经纬度)]
     * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
     * @param  [int]     $decimal   精度 保留小数位数
     * @return [string]  距离数值
     */
    function get_distance($from,$to,$km=false,$decimal=1){
        $from = explode(',', $from);
        $to = explode(',', $to);
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $distance = $EARTH_RADIUS*2*asin(sqrt(pow(sin( ($from[0]*pi()/180-$to[0]*pi()/180)/2),2)+cos($from[0]*pi()/180)*cos($to[0]*pi()/180)* pow(sin( ($from[1]*pi()/180-$to[1]*pi()/180)/2),2)))*1000;
        if($km){
            $distance = $distance / 1000;
        }
        return round($distance, $decimal);

    }


}
