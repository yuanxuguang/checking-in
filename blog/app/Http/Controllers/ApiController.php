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
            'phone_num' => 'required|unique:staff',
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
            ],[
             'phone_num.unique' => '该手机号已被注册'
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
            $path = str_replace('public','/storage',$path);
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

    //安全装备
    public function safetyEquip(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required',
            'quip_video' => 'required',
            'eid' => 'required',
        ],[
            'sid.required' => '员工id不能为空',
            'video.required' => '装备摄像不能为空',
            'eid.required' => 'eid不能为空',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data = request()->all();
        $data['start_time'] = date('Y-m-d H:i:s',time());
        $data['date'] = date('Y-m-d',time());
        $data['type'] = '3';
        if(request()->hasFile('quip_video')){
            $path = Storage::putFileAs('/public/c_video',request('quip_video'),date('Ymd').'_'.date('His').'.mp4');
            $path = str_replace('public','/storage',$path);
            $data['quip_video'] = $path;
        }
        $bool = DB::table('clock')->insert($data);
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

    //上班打卡-人脸识别
    public function clockFace(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required',
            'face_img' => 'required',
            'eid' => 'required',
            'coordinate' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data = request()->all();
        $data['start_time'] = date('Y-m-d H:i:s',time());
        $data['date'] = date('Y-m-d',time());
        $data['type'] = '1';
        if(request()->hasFile('face_img')){
            $path = Storage::putFileAs('/public/c_face_img',request('face_img'),date('Ymd').'_'.date('His').'.png');
            $path = str_replace('public','/storage',$path);
            $data['face_img'] = $path;
        }
//        　　$headers = ['Content-type' => 'application/json', 'Accept' => 'application/json', 'Authorization' => $options['http']['header']['authorization'], 'Date' => $date1];
//        　　$request = new Request('POST','https://dtplus-cn-shanghai.data.aliyuncs.com/face/attribute',$headers,$body1);


        //做人脸比对
        $url = "https://dtplus-cn-shanghai.data.aliyuncs.com/face/verify";
        $face['image_url_1'] = "http://1.yxg404.top".$data['face_img'];
        $s_img = DB::table('staff')->where('id',request('sid'))->select('face_img')->first();
        $face['image_url_2'] = "http://1.yxg404.top".$s_img->face_img;
        $face['type'] = 0;

        $face = json_encode($face,true);
        $is_face = $this->face_check($face);

        dd($is_face);
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
        $data['s_type'] = '1';
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
    //确认合约-获取主合约
    public function confirmContract1(){
        $validator = Validator::make(request()->all(),[
            'eid' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $contracts = DB::table('contract')->where('eid',request('eid'))->where('c_type','1')->select('id','eid','c_name')->get();
        if(!$contracts->isEmpty()){
            $message = 'success';
            $code = 200;
            $data = $contracts;
        }elseif($contracts->isEmpty()){
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

    //确认合约-根据主合约获取子合约
    public function confirmContract2(){
        $validator = Validator::make(request()->all(),[
            'cid' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $contracts = DB::table('contract')->where('c_type','2')->where('up_contract_id',request('cid'))->select('id','c_name')->get();
        if(!$contracts->isEmpty()){
            $message = 'success';
            $code = 200;
            $data = $contracts;
        }elseif($contracts->isEmpty()){
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

    //确认合约-更新员工合约
    public function confirmContract3(){
        $validator = Validator::make(request()->all(),[
            'sid' => 'required|numeric',
            'c_cid' => 'required|numeric',
            'c_c_type' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $bool = DB::table('staff')->where('id',request('sid'))->update(['c_id'=>request('c_cid'),'c_c_type'=>request('c_c_type')]);
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

    //文字记录
    public function textRecord(){
        $validator = Validator::make(request()->all(),[
            'eid'  => 'required|numeric',
            'sid'  => 'required|numeric',
            'cid'  => 'required|numeric',
            'type' => 'required',
            'text' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data = request()->all();
        $data['r_time'] = date('Y-m-d H:i:s',time());
        $bool = DB::table('record')->insert($data);
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

    //通讯记录
    public function messageRecord(){
        $validator = Validator::make(request()->all(),[
            'eid'  => 'required|numeric',
            'sid'  => 'required|numeric',
            'receiver' => 'required',
            'cid'  => 'required|numeric',
            'text' => 'required',
            'title'=> 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data = request()->all();
        $data['type'] = '2';
        $data['r_time'] = date('Y-m-d H:i:s',time());
        $bool = DB::table('record')->insert($data);
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

    //图片记录
    public function imgRecord(){
        $validator = Validator::make(request()->all(),[
            'eid'  => 'required|numeric',
            'sid'  => 'required|numeric',
            'cid'  => 'required|numeric',
            'type' => 'required',
            'coordinate' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data['eid'] = request('eid');
        $data['sid'] = request('sid');
        $data['cid'] = request('cid');
        $data['coordinate'] =request('coordinate');
        $data['type'] = '3';
        if(request('l1')){
            if(request('l2')){
                if(request('l3')){
                    if(request('l4')){
                        if(request('l5')){
                            $data['l5'] = request('l5');
                        }
                        $data['l4'] = request('l4');
                    }
                    $data['l3'] = request('l3');
                }
                $data['l2'] = request('l2');
            }
            $data['l1'] = request('l1');
        }
        if(request('type') == 3){
            foreach(request()->all() as $key => $val){
                if(strpos($key,'img') !== false){
                    $picture[] = request()->all()[$key];
                }
            }
            if(isset($picture)){
                foreach($picture as $k=>$f){
                    $paths[] = $this->uploadImg($picture[$k],'img','img');
                }
                $data['img'] = json_encode($paths);
            }else{
                $json['code'] = 400;
                $json['message'] = "图片未上传";
                return json_encode($json);
            }
        }
        $data['r_time'] = date('Y-m-d H:i:s',time());
        $bool = DB::table('record')->insert($data);
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

    public function videoRecord(){
        $validator = Validator::make(request()->all(),[
            'eid'  => 'required|numeric',
            'sid'  => 'required|numeric',
            'cid'  => 'required|numeric',
            'type' => 'required',
            'coordinate' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $data['eid'] = request('eid');
        $data['sid'] = request('sid');
        $data['cid'] = request('cid');
        $data['coordinate'] =request('coordinate');
        $data['type'] = '4';
        if(request('l1')){
            if(request('l2')){
                if(request('l3')){
                    if(request('l4')){
                        if(request('l5')){
                            $data['l5'] = request('l5');
                        }
                        $data['l4'] = request('l4');
                    }
                    $data['l3'] = request('l3');
                }
                $data['l2'] = request('l2');
            }
            $data['l1'] = request('l1');
        }
        if(request('type') == 4){
            foreach(request()->all() as $key => $val){
                if(strpos($key,'video') !== false){
                    $picture[] = request()->all()[$key];
                }
            }
            if(isset($picture)){
                foreach($picture as $k=>$f){
                    $paths[] = $this->uploadImg($picture[$k],'video','video');
                }
                $data['video'] = json_encode($paths);
            }else{
                $json['code'] = 400;
                $json['video'] = "视频未上传";
                return json_encode($json);
            }
        }
        $data['r_time'] = date('Y-m-d H:i:s',time());
        $bool = DB::table('record')->insert($data);
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

    //历史记录
    public function recordList(){
        $validator = Validator::make(request()->all(),[
            'sid'  => 'required|numeric',
            'number' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $number = request('number');
        $page = request('page');
        $total = DB::table('record')
            ->where('sid',request('sid'))
            ->limit(45)->get();
        $totalPage = ceil(count($total)/$number);

        if(request('cid')){
            if(request('r_time')){
                $s_time = date('Y-m-d H:i:s',request('r_time'));
                $res = DB::table('record as a')
                    ->join('contract as b','a.cid','=','b.id')
                    ->where('a.sid',request('sid'))
                    ->where('a.cid',request('cid'))
                    ->where('a.r_time','>',$s_time)
                    ->offset($number*$page)
                    ->orderby('r_time','desc')
                    ->limit($number)
                    ->select('a.*','b.c_name')
                    ->get();
            }else{
                $res = DB::table('record as a')
                    ->join('contract as b','a.cid','=','b.id')
                    ->where('a.sid',request('sid'))
                    ->where('a.cid',request('cid'))
                    ->offset($number*$page)
                    ->orderby('r_time','desc')
                    ->limit($number)
                    ->select('a.*','b.c_name')
                    ->get();
            }
        }else{
            if(request('r_time')){
                $s_time = date('Y-m-d H:i:s',request('r_time'));
                $res = DB::table('record as a')
                    ->join('contract as b','a.cid','=','b.id')
                    ->where('a.sid',request('sid'))
                    ->where('a.r_time','>',$s_time)
                    ->offset($number*$page)
                    ->orderby('r_time','desc')
                    ->limit($number)
                    ->select('a.*','b.c_name')
                    ->get();
            }else{
                $res = DB::table('record as a')
                    ->join('contract as b','a.cid','=','b.id')
                    ->where('a.sid',request('sid'))
                    ->offset($number*$page)
                    ->orderby('r_time','desc')
                    ->limit($number)
                    ->select('a.*','b.c_name')
                    ->get();
            }
        }

        foreach($res as $k=>$v){
            $res[$k]->img = json_decode($v->img);
        }
        foreach($res as $k=>$v){
            $res[$k]->video = json_decode($v->video);
        }

        if(!$res->isEmpty()){
            $json['code'] = 200;
            $json['message'] = "success";
            $json['totalPage'] = $totalPage;
            $json['page'] = $page;
            $json['data'] = $res;
        }elseif($res->isEmpty()){
            $json['code'] = 200;
            $json['message'] = "没有数据";
            $json['data'] = [];
        }else{
            $json['code'] = 201;
            $json['message'] = "error";
        }
        return json_encode($json,true);
//        $list = DB::table('')
    }

    //记录详情
    public function recordDetail(){
        $validator = Validator::make(request()->all(),[
            'lid'  => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors(),'code' => 400,'data' => '']);
        }
        $record = DB::table('record')->where('id',request('lid'))->first();
        if($record){
            $message = 'success';
            $code = 200;
            $data = $record;
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

    //上传图片
    public function uploadImg($file,$folder,$file_prefix){
        // 构建存储的文件夹规则，值如：uploads/images/video/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "uploads/$folder/" . date("Ymd", time());

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/changan/public/uploads/video/201709/21/
        $upload_path = public_path() . '/' . $folder_name;
        // 获取文件的后缀名
        $extension = $file->getClientOriginalExtension();
        //给文件取名
        $file_name = $file_prefix.'_'.date('Y-m-d_His',time()).'_'.str_random(5).'.'.$extension;
        // 将文件到我们的目标存储路径中
        $file->move($upload_path,$file_name);
        return ["path" =>  "/$folder_name/$file_name"];
    }

    public function face_check($face){
        $akId = "LTAIC42XVos5hJNV";
        $akSecret = "94cDhOr6O2SoBY4o4985QhYXLPTG0B ";
        //更新api信息
        $url = "https://dtplus-cn-shanghai.data.aliyuncs.com/face/verify";
        $options = array(
            'http' => array(
                'header' => array(
                    'accept'=> "application/json",
                    'content-type'=> "application/json",
                    'date'=> gmdate("D, d M Y H:i:s \G\M\T"),
                    'authorization' => ''
                ),
                'method' => "POST", //可以是 GET, POST, DELETE, PUT
                'content' => $face //如有数据，请用json_encode()进行编码
            )
        );
        $http = $options['http'];
        $header = $http['header'];
        $urlObj = parse_url($url);
        if(empty($urlObj["query"]))
            $path = $urlObj["path"];
        else
            $path = $urlObj["path"]."?".$urlObj["query"];
        $body = $http['content'];
        if(empty($body))
            $bodymd5 = $body;
        else
            $bodymd5 = base64_encode(md5($body,true));
        $stringToSign = $http['method']."\n".$header['accept']."\n".$bodymd5."\n".$header['content-type']."\n".$header['date']."\n".$path;
        $signature = base64_encode(
            hash_hmac(
                "sha1",
                $stringToSign,
                $akSecret, true));
        $authHeader = "Dataplus "."$akId".":"."$signature";
        $options['http']['header']['authorization'] = $authHeader;
        $options['http']['header'] = implode(
            array_map(
                function($key, $val){
                    return $key.":".$val."\r\n";
                },
                array_keys($options['http']['header']),
                $options['http']['header']));
        $context = stream_context_create($options);
        $file = file_get_contents($url, false, $context );
//        $ifno = $this->curl($url,$context);
//        dd($ifno);
        echo($file);
    }

    public function curl($url,$data,$timeout=5){
        if($url == '' || $data == '' || $timeout <=0){
            return false;
        }
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_POSTFIELDS, $data);
        curl_setopt($con, CURLOPT_POST,true);
        curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($con, CURLOPT_TIMEOUT,(int)$timeout);
        $output = curl_exec($con);
        if($output === FALSE ){
            echo "CURL Error:".curl_error($con);
        }
        // 4. 释放curl句柄
        curl_close($con);
        return $output;
    }
}
