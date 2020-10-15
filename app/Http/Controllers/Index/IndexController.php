<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	//首页
    public function index(){
    	return view('index.index');
    }
    //列表页
    public function search(){
    	return view('index.search');
    }
    //详情页
    public function item(){
    	return view('index.item');
    }
    
}
