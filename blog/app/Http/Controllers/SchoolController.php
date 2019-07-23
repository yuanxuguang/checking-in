<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SchoolController extends Controller
{
    //
    public function list(){
        $lists = DB::table('employer')->paginate(10);
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

    }

    public function editInsert(){

    }

    public function del($id){

    }

}
