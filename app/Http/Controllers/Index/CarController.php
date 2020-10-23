<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\CartModel;
use App\Goods;
class CarController extends Controller
{
	//购物车页面
    public function cart(){
    	$cate=CartModel::leftjoin('p_goods','p_cart.goods_id','=','p_goods.goods_id')->limit(5)->get();
    	// dd($cate);
        return view('index.cart',['cate'=>$cate]);
    }

    //购物车购买数量
	public function changeNumber(){
		$goods_id = Request()->input("goods_id");
		$buy_number = Request()->input("buy_number");
		$user_id = $this->sessionUserId();
		$where = [
				['user_id','=',$user_id],
				['goods_id','=',$goods_id],
				['is_delete','=',1]
		];
        $goods_price = Goods::select('goods_price')->where('goods_id',$goods_id)->first()->toArray();
		$goods_price = $goods_price['goods_price'];
		$goods_totall = $buy_number*$goods_price;
		$res = CartModel::where($where)->update(['buy_number'=>$buy_number,'goods_totall'=>$goods_totall]);
		if($res!==false){
			success("修改成功");
		}else{
			error("操作失败");
		}
	}
	//购物车小计
    public function getTotal(){

		$goods_id = Request()->input("goods_id");
		$user_id = $this->sessionUserId();
		$where = [
				['p_goods.goods_id','=',$goods_id],
				['user_id','=',$user_id],
				['p_cart.is_del','=',1]
		];
		$car = CarModel::join("p_goods","p_cart.goods_id","=","p_goods.goods_id")
				->where($where)
				->first();
		echo $sj = $car['buy_number']*$car['goods_price'];exit;
	}
	//总价
	public function getMoney(){
		$goods_id = Request()->input("goods_id");
		$goods_id = explode(',',$goods_id);
		$user_id = $this->sessionUserId();
		$where = [
				['user_id','=',$user_id],
				['p_cart.is_del','=',1]
		];
		$car = CarModel::join("p_goods","p_cart.goods_id","=","p_goods.goods_id")
				->where($where)
				->whereIn('p_cart.goods_id',$goods_id)
				->get();
		if(!empty($car[0])){
			$MoneyAll = 0;
			foreach($car as $k=>$v){
				$MoneyAll+=$v['goods_price']*$v['buy_number'];
			}
			echo $MoneyAll;exit;
		}
	}
	//删除
	public function del(){
		$goods_id=request()->goods_id;
		//return 1234;
		    $data=["add_time"=>time(),"is_del"=>0];
			$res=CarModel::where("goods_id",$goods_id)->update($data);
			if($res){
				success("删除成功");
			}
	}


	public function orderInfo(){
		return view('index.orderInfo');
	}

}
