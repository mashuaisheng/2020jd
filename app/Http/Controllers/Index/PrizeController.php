<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Model\PrizeModel;
class PrizeController extends Controller
{
	public function prize(){
		
		return view('index.prize');
		// if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])){
		// 		return view('index.prize');
  //           }else{
  //               return redirect('/lo');
  //           }
	}
	public function add(){
		$user_id = session()->get('user_id');
        if(empty($user_id))     //未登录
        {
            $response = [
                'errno' => 400003,
                'msg'   => '未登录'
            ];

            return $response;
        }

        //检查用户当天是否已有抽奖记录
        $time1 = strtotime(date("Y-m-d"));
        $res = PrizeModel::where(['user_id'=>$user_id])->where("add_time",">=",$time1)->first();
        if($res)        //已经有记录
        {
            $response = [
                'errno' => 300008,
                'msg'   => '今天已经抽过奖了，请明天再来吧'
            ];

            return $response;
        }

        $rand = mt_rand(1,100000);
        $level = 0;
		echo "您的幸运号是：".$rand;

        if($rand>=1 && $rand<=100)
        {
            //一等奖
            $level = 1;
        }elseif ($rand >=101 && $rand <=3000){            //二等奖
            $level = 2;
        }elseif($rand>=30001 && $rand<=36000){
            // 三等奖
            $level = 3;
        }


        //记录抽奖信息
        $prize_data = [
            'user_id'   => $user_id,
            'level' => $level,
            'add_time'  => time()
        ];

        $pid = PrizeModel::insertGetId($prize_data);

        //是否记录成功
        if($pid>0)
        {
            $data = [
                'errno' => 0,
                'msg'   => 'ok',
                'data'  => [
                    'level' => $level       //中奖等级
                ]
            ];

        }else{
            //异常
            $data = [
                'errno' => 500008,
                'msg'   => "数据异常，请重试"
            ];
        }
        return $data;

		
		// if($number==50000){
		// 	$prize="  恭喜你，获得一等奖";
		// }elseif ($number==30000 || $number==30000) {
		// 	$prize="  恭喜你，获得二等奖";
		// }elseif ($number==20000 || $number==25000 || $number==22000) {
		// 	$prize="  恭喜你，获得三等奖";
		// }else{
		// 	$prize="  谢谢惠顾";
		// }
		// $data=[
		// 	'error' => "2",
		// 	'msg'   => 'ok',
		// 	'data' =>[
		// 		'prize'=>$prize
		// 	]
		// ];
		// return $prize;
	}

}