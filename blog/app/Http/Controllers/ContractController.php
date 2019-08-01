<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/19
 * Time: 14:17
 */

namespace App\Http\Controllers;
use \App\Contract;
use Illuminate\Http\Request;
use Storage;
use DB;
class ContractController extends Controller
{
    public function list(){

        if(request('c_name') && request('c_type')){
            $contracts = Contract::where('c_name',request('c_name'))->where('c_type',request('c_type'))->where('eid',session('eid'))->paginate(10);
        }else if(request('c_name') && !request('c_type')){
            $contracts = Contract::where('c_name',request('c_name'))->where('eid',session('eid'))->paginate(10);
        }else if(!request('c_name') && request('c_type')){
            $contracts = Contract::where('c_type',request('c_type'))->where('eid',session('eid'))->paginate(10);
        }else{
            $contracts = Contract::where('eid',session('eid'))->paginate(10);
        }
//        $a = $contracts->byUpContract()->get();
        return view('contract.list',compact('contracts'));
    }

    public function add(){
        $api_addr = request()->all();
        //外判雇主列表
        $out_employers = DB::table('employer')->where('id',session('eid'))->get();
        $up_contracts = DB::table('contract')->where('c_type',"1")->get();

        return view('contract.add',compact('out_employers','up_contracts','api_addr'));
    }

    public function insert(Request $request){
//        if(!$request['out_employer']){
//            $data = $request->except('out_employer','up_contract');
//        }else{

//        }
        $data = $request->except('out_employer');
        $data['eid'] = session('eid');
//        $employer = DB::table('employer')->where('id',session('eid'))->first();
        if(request()->hasFile('c_img')){
            $path = Storage::putFileAs('/public/c_img',request('c_img'),date('Ymd').'_'.date('His').'.png');
            $path = str_replace('public','storage',$path);
            $data['c_img'] = $path;
        }
        if($request['up_contract_id']){
            $up_contract_name = DB::table('contract')->where('id',$request['up_contract_id'])->select('c_name')->first();
            $data['up_contract_name'] = $up_contract_name->c_name;
        }else{
            $data['up_contract_name'] = '无';
        }
        $info = \DB::table('contract')->insert($data);
        $info = empty($info)?0:1;
        return ['info' =>$info];
    }

    public function edit($cid){
        $contract = Contract::where('id',$cid)->first();
        //外判雇主列表
        $out_employers = DB::table('employer')->where('id',session('eid'))->get();
        $up_contracts = DB::table('contract')->where('c_type',"1")->get();
        return view('contract.edit',compact('contract','out_employers','up_contracts'));
    }

    public function editInsert(Request $request){
        $data = $request->except('out_employer');
        $data['eid'] = session('eid');
//        $employer = DB::table('employer')->where('id',session('eid'))->first();
        if(request()->hasFile('c_img')){
            $path = Storage::putFileAs('/public/c_img',request('c_img'),date('Ymd').'_'.date('His').'.png');
            $path = str_replace('public','storage',$path);
            $data['c_img'] = $path;
        }
        if($request['up_contract_id']){
            $up_contract_name = DB::table('contract')->where('id',$request['up_contract_id'])->select('c_name')->first();
            $data['up_contract_name'] = $up_contract_name->c_name;
        }else{
            $data['up_contract_name'] = '无';
        }
        $info = \DB::table('contract')->where('id',$request['id'])->update($data);
        $info = empty($info)?0:1;
        return ['info' =>$info];
    }

    public function delete(){
        $info = DB::table('contract')->where('id',request('id'))->delete();
        return ['info'=>$info ];
    }

    public function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }
        return (object)$arr;
    }




}