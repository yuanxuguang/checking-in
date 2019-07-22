<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/19
 * Time: 14:17
 */

namespace App\Http\Controllers;


class ContractController extends Controller
{
    public function list(){
        return view('contract.list');
    }

    public function add(){
        return view('contract.add');
    }

    public function insert(){

    }

    public function edit(){
        return view('contract.edit');
    }

    public function editInsert(){

    }

    public function delete(){

    }

}