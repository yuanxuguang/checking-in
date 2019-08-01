<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Label;
class LabelController extends Controller
{
    //
    public function list(){

        $lists = Label::where('eid',session('eid'))->paginate(10);
        return view('label.list',compact('lists'));
    }

    public function add(){
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();
        $schools = DB::table('school')->where('eid',session('eid'))->get();
        $is_upLabel = DB::table('label')->where('eid',session('eid'))->where('level','1')->count();
        if($is_upLabel){//判断是否有一级,没有直接返回视图
                $up1_labels = DB::table('label')->where('eid',session('eid'))->where('level','1')->get();
                return view('label.add',compact('contracts','schools','is_upLabel','up1_labels'));
            }
        return view('label.add',compact('contracts','schools','is_upLabel'));
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

        $bool = DB::table('label')->insert($data);
        return ['info' => $bool];
    }

    public function edit(){

    }

    public function editInsert(){

    }

    public function getLevel2Label(){
        $list = DB::table('label')->where('up_label',request('lid'))->get();
        return json_encode($list,true);
    }

}
