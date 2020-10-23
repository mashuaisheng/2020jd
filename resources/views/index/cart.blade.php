@extends('layouts.car')
      @section('titles','购物车列表')
      @section('contentc')
		<!--All goods-->
		<div class="allgoods">
			<h4>全部商品<span>11</span></h4>
			<div class="cart-main">
				<div class="yui3-g cart-th">
					<div class="yui3-u-1-4"><input type="checkbox" name="" id="" value="" /> 全部</div>
					<div class="yui3-u-1-4">商品</div>
					<div class="yui3-u-1-8">单价（元）</div>
					<div class="yui3-u-1-8">数量</div>
					<div class="yui3-u-1-8">小计（元）</div>
					<div class="yui3-u-1-8">操作</div>
				</div>
				<div class="cart-item-list">
					<div class="cart-shop">
						<input type="checkbox" name="" id="" value="" />
						<span class="shopname self">传智自营</span>
					</div>
					@foreach($cate as $k=>$v)
					<div class="cart-body">
						<div class="cart-list">
							<ul class="goods-list yui3-g">
								<li class="yui3-u-1-24">
									<input type="checkbox" name="" id="" value="" />
								</li>
								<li class="yui3-u-11-24">
									<div class="good-item">
										<div class="item-img"><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" /></div>
										<div class="item-msg">{{$v->goods_name}}</div>
									</div>
								</li>
								
								<li class="yui3-u-1-8"><span class="price" goods_number="{{$v['goods_number']}}">{{$v->shop_price}}</span></li>
								<li class="yui3-u-1-8">
									<a href="javascript:void(0)" class="increment mins" id="jian">-</a>
									<input autocomplete="off" type="text" id="buy_number"  value="{{$v['buy_number']}}" class="itxt" />
									<a href="javascript:void(0)" class="increment plus" id="add">+</a>
								</li>
								<li class="yui3-u-1-8"><span class="sum">8848.00</span></li>
								<li class="yui3-u-1-8">
									<a href="#none">删除</a><br />
									<a href="#none">移到我的关注</a>
								</li>
							</ul>
						</div>
					</div>
					@endforeach
				</div>
			<div class="cart-tool">
				<div class="select-all">
					<input type="checkbox" name="" id="" value="" />
					<span>全选</span>
				</div>
				<div class="option">
					<a href="#none">删除选中的商品</a>
					<a href="#none">移到我的关注</a>
					<a href="#none">清除下柜商品</a>
				</div>
				<div class="toolbar">
					<div class="chosed">已选择<span>0</span>件商品</div>
					<div class="sumprice">
						<span><em>总价（不含运费） ：</em><i class="summoney">¥16283.00</i></span>
						<span><em>已节省：</em><i>-¥20.00</i></span>
					</div>
					<div class="sumbtn">
						<a class="sum-btn" href="{{url('/orderInfo')}}" target="_blank">结算</a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
	@endsection
<script type="text/javascript" src="/static/plugins/jquery/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		//点击+号
		$(document).on("click","#add",function(){
			var _this = $(this);
			//获取文本框的购买数量
            var buy_number=parseInt($("#buy_number").val());
            //获取库存
            var goods_number=parseInt($("#goods_number").text());
            // 判断购买数量是否大于库存
            if(buy_number>=goods_number){
                $("#buy_number").val(goods_number);//判断购买数量>=库存的值
            }else{
                buy_number=buy_number+1;
                $("#buy_number").val(buy_number);//购买数量+1，并显示值
            }
		});
		//更改购买数量
		function changeNum(_this,buy_number){
			var goods_id = _this.parents("ul").attr("goods_id");
			$.ajax({
				url:"{{url('/changeNumber')}}",
				data:{'goods_id':goods_id,'buy_number':buy_number},
				type : 'post',
				dataType : 'json',
				async : false,
				success:function(res){
					if(res.error_no==0){
						console.log(res);
					}else{
						alert(res.error_msg);
					}
				}
			});
		}
		//获取小计
		function getTotal(_this){
			var goods_id = _this.parents("ul").attr("goods_id");
			$.ajax({
				url:"{{url('/shop/buycar/getTotal')}}",
				data:{'goods_id':goods_id},
				type : 'post',
				success:function(res){
					_this.parents("li").next().find('.sum').text(res);
				}
			});
		}
		//获取总价
		function getMoney(){
			var _box = $(".box:checked");
			var goods_id = "";
			_box.each(function(index){
				goods_id+=$(this).parents("ul").attr("goods_id")+',';
			});
			goods_id = goods_id.substring(0,goods_id.length-1);
			$.ajax({
				url:"{{url('/shop/buycar/getMoney')}}",
				data:{'goods_id':goods_id},
				type : 'post',
				success:function(res){
					if(res == ''){
						res = '0';
					}
					$(".summoney").text('￥'+res);
				}
			});

		}
		//点击减号
		$(document).on("click","#jian",function(){
			//获取购买数量
            var buy_number=parseInt($("#buy_number").val());
            //判断购买数量是否小于1
            if(buy_number<=1){
                $("#buy_number").val(1);//购买数量<=1
            }else{
                buy_number=buy_number-1;//购买数量-1
                $("#buy_number").val(buy_number);//购买数量-1后的值
            }
		});
		//失去焦点
		$(document).on("blur","#buy_number",function(){
			//获取购买数量
            var buy_number=$("#buy_number").val();
            //获取库存的值
            var goods_number=$("#goods_number").text();
            //alert(goods_number);
            var reg=/^\d+$/;//检测值最少为一位数字
            if(buy_number==''){
                $("#buy_number").val(1);//判断购买数量为空
            }else if(!reg.test(buy_number)){
                $("#buy_number").val(1);//判断购买数量是否为数字
            }else if(parseInt(buy_number)<1){
                $("#buy_number").val(1);//判断购买数量小于1
            }else if(parseInt(buy_number)>=goods_number){
                $("#buy_number").val(goods_number);//判断购买数量>库存
            }else{
                $("#buy_number").val(parseInt(buy_number));//判断购买数量改变为整数
            }
		});
		//点击确结算
		$(document).on("click","#confirmSettlement",function(){
			var _box = $(".box:checked");

			if(_box.length==0){
				alert("请选择要进行结算的商品");return false;
			}
			var goods_id = "";
			_box.each(function(index){
				goods_id+=$(this).parents("ul").attr("goods_id")+',';
			});
			//console.log(goods_id);return false;
			goods_id = goods_id.substring(0,goods_id.length-1);
			//console.log(goods_id);return false;
			location.href ="/shop/getorderinfo/"+goods_id;
		});
		
	});
</script>