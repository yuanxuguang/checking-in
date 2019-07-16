<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    public function loginView(){
        return view("login");
    }

    public function commonView(){
        return view('public.commonView');
    }

    public function indexView(){
        return view('hello');
    }

}
