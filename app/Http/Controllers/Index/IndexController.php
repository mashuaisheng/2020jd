<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Model\CartModel;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
	//首页
    public function index(){
        session_start();
    	return view('index.index');
    }


    //列表页
    public function search(){
        $data=Goods::limit(10)->get();//查询10条数据进行展示
        //dd($data);
    	return view('index.search',['data'=>$data]);
    }
    //详情页
    public function goods(Request $request,$goods_id){
        $key = 'h:goods_info:'.$goods_id;
        //查询缓存
        $goods = Redis::hGetAll($key);
        if($goods)      //有缓存
        {
            //echo "有缓存，不用查询数据库";
        }else{
            //echo "无缓存，正在查询数据库";
            //获取商品信息
            $goods_info = Goods::find($goods_id);
            if(empty($goods_info))
            {
                echo "商品不存在";
                die;
            }
            $goods = $goods_info->toArray();
            //print_r($goods_id);
            //存入缓存
            Redis::hMset($key,$goods);
            //echo "数据存入Redis中";
        }
       // echo "<pre>";print_r($goods);exit;
        $data = [
            'goods' => $goods
        ];
        //dd($data);
        return view('index.goods',$data);
    }
    

    //计入购物车
    public function ll(request $request){
        //接受数据
        $goods_id=$request->input('goods_id');
        $buy_number=$request->input('buy_number');
        $res=Goods::where("goods_id",$goods_id)->value("goods_number");
        if($res){
            echo '加入购物车成功';
        }else{
            echo '加入购物车失败';
        }
    }
    public function addCart(Request $request,$goods_id){
        session_start();
        $goods_id = $request->post('goods_id');
        $user_id = session()->get('user_id');
        $buy_number = $request->get('buy_number');
        //print_r($user_id);exit;
        //购物车保存商品信息
        $cart_info = [
            'user_id'       => $user_id,
            'add_time'  => time(),
            'buy_number' => $buy_number,
            'goods_id' => $goods_id
        ];
         $res = CartModel::insertGetId($cart_info);
        if($res>0)
        {
            $data = [
                'errno' => 0,
                'msg'   => '成功加入购物车'
            ];
            echo json_encode($data);
        }else{
            $data = [
                'errno' => 500001,
                'msg'   => '加入购物车失败'
            ];
            echo json_encode($data);
        }
    }

    
}
