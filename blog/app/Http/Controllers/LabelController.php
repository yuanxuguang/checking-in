<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class LabelController extends Controller
{
    //
    public function list(){
        $contracts = DB::table('contract')->where('eid',session('eid'))->paginate(10);
        return view('label.list',compact('contracts'));
    }

    public function add(){
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();
        $schools = DB::table('school')->where('eid',session('eid'))->get();
        $is_upLabel = DB::table('label')->where('eid',session('eid'))->where('level','1')->count();
        if($is_upLabel){
            $up1_labels = DB::table('label')->where('eid',session('eid'))->where('level','1')->get();
            return view('label.add',compact('contracts','schools','is_upLabel','up1_labels'));
        }
        return view('label.add',compact('contracts','schools','is_upLabel'));
    }

    public function insert(){
        $data = request()->all();
        $data['eid'] = session('eid');
        if(!request('up_label')){
            $data['level'] = 1;
        }
//        dd($data);
        $bool = DB::table('label')->insert($data);
        return ['info' => $bool];
    }

    public function edit(){

    }

    public function editInsert(){

    }

}
