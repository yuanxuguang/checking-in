<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Label;
use App\QRcode as qrcode;
class LabelController extends Controller
{
    //
    public function list(Request $request){
        if(request('l_type') && request('contract')){
            $lists = Label::where('eid',session('eid'))->where('l_type',request('l_type'))->where('c_id',request('contract'))->paginate(10);
        }elseif(request('l_type')){
            $lists = Label::where('eid',session('eid'))->where('l_type',request('l_type'))->paginate(10);
        }elseif(request('contract')){
            $lists = Label::where('eid',session('eid'))->where('c_id',request('contract'))->paginate(10);
        }else{
            $lists = Label::where('eid',session('eid'))->paginate(10);
        }
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();

        return view('label.list',compact('lists','contracts','request'));
    }

    public function add(){
        $api_addr = request()->all();
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();
        $schools = DB::table('school')->where('eid',session('eid'))->get();
        $is_upLabel = DB::table('label')->where('eid',session('eid'))->where('level','1')->count();
        if($is_upLabel){//判断是否有一级,没有直接返回视图
           $up1_labels = DB::table('label')->where('eid',session('eid'))->where('level','1')->get();
           return view('label.add',compact('contracts','schools','is_upLabel','up1_labels','api_addr'));
        }
        return view('label.add',compact('contracts','schools','is_upLabel','api_addr'));
    }

    public function insert(Request $request){
        $data = $request->except('up_label1','up_label2','up_label3','up_label4');

        $data['eid'] = session('eid');
        if(request('up_label1')){ //判断是否是一级标签
            if(request('up_label2')){ //判断是否是二级级标签
                if(request('up_label3')){  //判断是否是三级标签
                    if(request('up_label4')){//判断是否是四级级标签
                        $up_label = DB::table('label')->where('id',request('up_label4'))->first();
                        $data = array_diff_key($data,['up_label1' => 'x','up_label2' => 'y','up_label3' => 'e']);
                        $data['up_label'] = request('up_label4');
                    }else{
                        $up_label = DB::table('label')->where('id',request('up_label3'))->first();
                        $data = array_diff_key($data,['up_label1' => 'x','up_label2' => 'y']);
                        $data['up_label'] = request('up_label3');
                    }
                }else{
                    $up_label = DB::table('label')->where('id',request('up_label2'))->first();
                    $data['up_label'] = request('up_label2');
                }
            }else{
                $up_label = DB::table('label')->where('id',request('up_label1'))->first();
                $data['up_label'] = request('up_label1');
            }
            $data['s_id'] = $up_label->s_id;
            $data['c_id'] = $up_label->c_id;
            $data['level'] = (int)$up_label->level+1;
        }else{
            $data['level'] = 1;
        }
        $lid = DB::table('label')->insertGetId($data);
        if($lid){
            //生成二维码索引
            $json['l_id'] = $lid;
            $json['latng'] = request('api_latng');
            $json['l_name'] = $data['l_name'];
            $json['c_id'] =$data['c_id'];
            qrcode::png(json_encode($json),'code'.$lid.'.png','L',7,3,1);
            rename('code'.$lid.'.png','code/code'.$lid.'.png');
            DB::table('label')->where('id',$lid)->update(['code_img' => '/code/code'.$lid.'.png']);
        }
        return ['info' => $lid];
    }

    public function edit($lid){
        $api_addr = request()->all();
        $label = DB::table('label')->where('id',$lid)->where('eid',session('eid'))->first();
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();
        if($label->level == 2){
            $up1_Label = DB::table('label')->where('level',1)->where('eid',session('eid'))->get();
            $label->one_label = $label->up_label;
        }else if($label->level == 3){
            $up1_Label = DB::table('label')->where('level',1)->where('eid',session('eid'))->get();
            $up2_Label = DB::table('label')->where('id',$label->up_label)->where('eid',session('eid'))->first();
            $label->one_label = $up2_Label->up_label;
            return view('label.edit',compact('label','contracts','up1_Label','api_addr','up2_Label'));
        }else if($label->level == 4){
            $up1_Label = DB::table('label')->where('level',1)->where('eid',session('eid'))->get();
            $up3_Label = DB::table('label')->where('id',$label->up_label)->where('eid',session('eid'))->first();
            $up2_Label = DB::table('label')->where('id',$up3_Label->up_label)->where('eid',session('eid'))->first();
            $label->one_label = $up2_Label->up_label;
            $label->two_label = $up3_Label->up_label;
//            dd($up3_label);
            return view('label.edit',compact('label','contracts','up1_Label','api_addr','up2_Label','up3_Label'));
        }else{
            $up1_Label = DB::table('label')->where('level',1)->where('eid',session('eid'))->get();
            $label->one_label = $label->up_label;
        }
        return view('label.edit',compact('label','contracts','up1_Label','api_addr'));
    }

    public function editInsert(Request $request){
        $data = $request->except('up_label1','up_label2','up_label3','up_label4');
        if(request('l_type') === '1'){
            //生成二维码索引
            $json['l_id'] = request('id');
            $json['latng'] = request('api_latng');
            $json['l_name'] = request('l_name');
            $json['c_id'] =request('c_id');
            qrcode::png(json_encode($json),'code'.request('id').'.png','L',7,3,1);
            rename('code'.request('id').'.png','code/code'.request('id').'.png');
            $data['code_img'] = '/code/code'.request('id').'.png';
        }else{
            if(request('up_label1')){ //判断是否是一级标签
                if(request('up_label2')){ //判断是否是二级级标签
                    if(request('up_label3')){  //判断是否是三级标签
                        if(request('up_label4')){//判断是否是四级级标签
                            $up_label = DB::table('label')->where('id',request('up_label4'))->first();
                            $data = array_diff_key($data,['up_label1' => 'x','up_label2' => 'y','up_label3' => 'e']);
                            $data['up_label'] = request('up_label4');
                        }else{
                            $up_label = DB::table('label')->where('id',request('up_label3'))->first();
                            $data = array_diff_key($data,['up_label1' => 'x','up_label2' => 'y']);
                            $data['up_label'] = request('up_label3');
                        }
                    }else{
                        $up_label = DB::table('label')->where('id',request('up_label2'))->first();
                        $data['up_label'] = request('up_label2');
                    }
                }else{
                    $up_label = DB::table('label')->where('id',request('up_label1'))->first();
                    $data['up_label'] = request('up_label1');
                }
//                $data['s_id'] = $up_label->s_id;
//                $data['c_id'] = $up_label->c_id;
                $data['level'] = (int)$up_label->level+1;
            }else{
                $data['level'] = 1;
            }
        }
//        dd($data);
        $bool = DB::table('label')->where('id',request('id'))->update($data);
        return ['info' => $bool];
    }

    public function getLevel2Label(){
        $list = DB::table('label')->where('up_label',request('lid'))->get();
        return json_encode($list,true);
    }

}
