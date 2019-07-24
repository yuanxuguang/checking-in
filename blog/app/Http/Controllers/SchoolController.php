<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
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
        $bool = DB::table('school')->insert(request()->all());
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

}
