<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class JobController extends Controller
{
    //
    public function list(){
        $lists = DB::table('job')->where('eid',session('eid'))->paginate(10);
        return view('job.list',compact('lists'));
    }

    public function add(){
        return view('job.add');
    }

    public function insert(){
        $data = request()->all();
        $data['eid'] = session('eid');

        $bool = DB::table('job')->insert($data);
        return ['info' => $bool];
    }

    public function edit($id){
        $list = DB::table('job')->where('id',$id)->first();
        return view('job/edit',compact('list'));
    }

    public function editInsert(){
        $bool = DB::table('job')->where('id',request('id'))->update(request()->all());
        return ['info' => $bool];
    }

    public function delete(){
        $bool = DB::table('job')->where('id',request('id'))->delete();
        return ['info' => $bool];
    }
}
