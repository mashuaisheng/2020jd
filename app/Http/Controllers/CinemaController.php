<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cinema;
class CinemaController extends Controller
{
	public function index(){
        $data=Cinema::get();
        return view('cinema.index',['data'=>$data]);
    }
    public function cinadd(){
        
    }

}
