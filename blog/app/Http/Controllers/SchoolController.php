<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Excel;
use Storage;
class SchoolController extends Controller
{
    //
    public function list(){
        if(request('condition')){
            if(is_numeric(request('condition'))){
                $lists = DB::table('school')->where('s_num',request('condition'))->where('eid',session('eid'))->paginate(10);
            }else{
                $lists = DB::table('school')->where('s_name_zn',request('condition'))->where('eid',session('eid'))->paginate(10);
            }
        }else{
            $lists = DB::table('school')->where('eid',session('eid'))->paginate(10);
        }
        return view('school.list',compact('lists'));
    }

    public function add(){
        return view('school.add');
    }

    public function insert(){
        $data = request()->all();
        $data['eid'] = session('eid');
        $bool = DB::table('school')->insert($data);
        return ['info' => $bool];
    }

    public function edit($id){
        $list = DB::table('school')->where('id',$id)->first();
        return view('school.edit',compact('list'));
    }

    public function editInsert(){
        $bool = DB::table('school')->where('id',request('id'))->update(request()->all());
        return ['info' => $bool];
    }

    public function delete(){
        $bool = DB::table('school')->where('id',request('id'))->delete();
        return ['info' => $bool];
    }

    public function excelImport(){
//        dd($_FILES);
        if($_FILES['file']['error'] == 0){
            $name = $_FILES['file']['name'];
            //获取后缀
            $ext = strtolower(trim(substr($name,(strpos($name,'.')+1))));
            //判断是否是xls 或 xlsx文件
            if(!in_array($ext,array('xls','xlsx'))){
                return ['info' => -1];
            }
            //获取文件名称，我这里只需读取写入数据库，并不需要保存xls文件。
            $fileName = $_FILES['file']['tmp_name'];
            Excel::load($fileName, function ($reader){
                $data = $reader->all()[0]; //只取第一个sheet内容
                foreach($data as $v){

                    $info['s_num'] = (int)($v->num);
                    $info['s_name_zn'] = $v->name;
                    $info['s_name_en'] = $v->enname;
                    $info['s_name_short'] = $v->shortname;
                    $info['s_area'] = $v->area;
                    $info['s_address'] = $v->address;
                    $info['eid'] = session('eid');

                    DB::table('school')->insert($info);
                }
                //> 处理上传文件数据 此时 处理多个上传的 sheet 文件 这里不需要
//                foreach ($reader->get() as $item){
//                    //> 处理相关上传excel数据
//                    dump($item);
//                }
            });
            return ['info' => 1];
        }
    }
}
