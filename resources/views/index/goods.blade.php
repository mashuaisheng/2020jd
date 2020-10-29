@extends('layouts.jd')
      @section('title','详情页')

      @section('contents')
	<div class="py-container" goods_id="{{$goods['goods_id']}}">
		<div id="item">
			<div class="crumb-wrap">
				<ul class="sui-breadcrumb">
					<li>
						<a href="#">手机、数码、通讯</a>
					</li>
					<li>
						<a href="#">手机</a>
					</li>
					<li>
						<a href="#">Apple苹果</a>
					</li>
					<li class="active">iphone 6S系类</li>
				</ul>
			</div>
			<!--product-info-->
			<div class="product-info">
				<div class="fl preview-wrap">
					<!--放大镜效果-->
					<div class="zoom">
						<!--默认第一个预览-->
						<div id="preview" class="spec-preview">
							<span class="jqzoom">
								<img jqimg="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" src="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" />
							</span>
						</div>
						<!--下方的缩略图-->
						<div class="spec-scroll">
							<a class="prev">&lt;</a>
							<!--左右按钮-->
							<div class="items">
								<ul>
									<li><img src="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" bimg="/static/img/_/b1.png" onmousemove="preview(this)" /></li>
									<li><img src="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" bimg="/static/img/_/b2.png" onmousemove="preview(this)" /></li>
									<li><img src="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" bimg="/static/img/_/b2.png" onmousemove="preview(this)" /></li>
									<li><img src="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" bimg="/static/img/_/b3.png" onmousemove="preview(this)" /></li>
								</ul>
							</div>
							<a class="next">&gt;</a>
						</div>
					</div>
				</div>
				<div class="fr itemInfo-wrap">
					<div class="sku-name">
						<h4>{{$goods['goods_name']}}</h4>
					</div>
					<div class="news"><span>推荐选择下方[移动优惠购],手机套餐齐搞定,不用换号,每月还有花费返</span></div>
					<div class="summary">
						<div class="summary-wrap">
							<div class="fl title">
								<i>价　　格</i>
							</div>
							<div class="fl price">
								<i>¥</i>
								<em>{{$goods['shop_price']}}</em>
								<span>降价通知</span>
							</div>
							<div class="fr remark">
								<i>累计评价</i><em>{{$goods['click_count']}}</em>
							</div>
						</div>
						<div class="summary-wrap">
							<div class="fl title">
								<i>促　　销</i>
							</div>
							<div class="fl fix-width">
								<i class="red-bg">加价购</i>
								<em class="t-gray">满999.00另加20.00元，
购热销商品</em>
							</div>
						</div>
					</div>
					<div class="support">
						<div class="summary-wrap">
							<div class="fl title">
								<i>支　　持</i>
							</div>
							<div class="fl fix-width">
								<em class="t-gray">以旧换新，闲置手机回收  4G套餐超值抢  礼品购</em>
							</div>
						</div>
						<div class="summary-wrap">
							<div class="fl title">
								<i>配 送 至</i>
							</div>
							<div class="fl fix-width">
								<em class="t-gray">满999.00另加20.00元，或满1999.00另加30.00元，或满2999.00另加40.00元，即可在购物车换购热销商品</em>
								库存：<span id="goods_number">{{$goods['goods_number']}}</span>
							</div>
						</div>
					</div>
					<div class="clearfix choose">
						<div id="specification" class="summary-wrap clearfix">
							<dl>
								<dt>
									<div class="fl title">
									<i>选择颜色</i>
								</div>
								</dt>
								<dd><a href="javascript:;" class="selected">金色<span title="点击取消选择">&nbsp;</span></a></dd>
								<dd><a href="javascript:;">银色</a></dd>
								<dd><a href="javascript:;">黑色</a></dd>
							</dl>
							<dl>
								<dt>
									<div class="fl title">
									<i>选择版本</i>
								</div>
								</dt>
								<dd><a href="javascript:;" class="selected">公开版<span title="点击取消选择">&nbsp;</span></a></dd>
								<dd><a href="javascript:;">移动版</a></dd>							
							</dl>
						</div>
						<input type="hidden" value="{{$goods['goods_id']}}" goods_id="{{$goods['goods_id']}}" id="goods_id">
						<div class="summary-wrap">
							<div class="fl title">
								<div class="control-group">
									<div class="controls">
										<input autocomplete="off" type="text" value="1" minnum="1" class="itxt" id="buy_number" />
										<a href="javascript:void(0)" class="increment plus" id="add">+</a>
										<a href="javascript:void(0)" class="increment mins" id="less">-</a>
									</div>
								</div>
							</div>
							<div class="fl">
								<ul class="btn-choose unstyled">
									<li>
										<a href="javascript:void(0)" class="sui-btn  btn-danger addshopcar" id="addcart">加入购物车</a>
										<a href="javascript:void(0)" class="sui-btn  btn-danger addshopcar" id="show">收藏</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--product-detail-->
			<div class="clearfix product-detail">
				<div class="fl aside">
					<ul class="sui-nav nav-tabs tab-wraped">
						<li class="active">
							<a href="#index" data-toggle="tab">
								<span>相关分类</span>
							</a>
						</li>
						<li>
							<a href="#profile" data-toggle="tab">
								<span>推荐品牌</span>
							</a>
						</li>
					</ul>
					<div class="tab-content tab-wraped">
						<div id="index" class="tab-pane active">
							<ul class="part-list unstyled">
								<li>手机</li>
								<li>手机壳</li>
								<li>内存卡</li>
								<li>Iphone配件</li>
								<li>贴膜</li>
								<li>手机耳机</li>
								<li>移动电源</li>
								<li>平板电脑</li>
							</ul>
							<ul class="goods-list unstyled">
								<li>
									<div class="list-wrap">
										<div class="p-img">
											<img src="/static/img/_/part01.png" />
										</div>
										<div class="attr">
											<em>Apple苹果iPhone 6s (A1699)</em>
										</div>
										<div class="price">
											<strong>
											<em>¥</em>
											<i>6088.00</i>
										</strong>
										</div>
										<div class="operate">
											<a href="javascript:void(0);" class="sui-btn btn-bordered">加入购物车</a>
										</div>
									</div>
								</li>
								<li>
									<div class="list-wrap">
										<div class="p-img">
											<img src="/static/img/_/part02.png" />
										</div>
										<div class="attr">
											<em>Apple苹果iPhone 6s (A1699)</em>
										</div>
										<div class="price">
											<strong>
											<em>¥</em>
											<i>6088.00</i>
										</strong>
										</div>
										<div class="operate">
											<a href="javascript:void(0);" class="sui-btn btn-bordered">加入购物车</a>
										</div>
									</div>
								</li>
								<li>
									<div class="list-wrap">
										<div class="p-img">
											<img src="/static/img/_/part03.png" />
										</div>
										<div class="attr">
											<em>Apple苹果iPhone 6s (A1699)</em>
										</div>
										<div class="price">
											<strong>
											<em>¥</em>
											<i>6088.00</i>
										</strong>
										</div>
										<div class="operate">
											<a href="javascript:void(0);" class="sui-btn btn-bordered">加入购物车</a>
										</div>
									</div>
									<div class="list-wrap">
										<div class="p-img">
											<img src="/static/img/_/part02.png" />
										</div>
										<div class="attr">
											<em>Apple苹果iPhone 6s (A1699)</em>
										</div>
										<div class="price">
											<strong>
											<em>¥</em>
											<i>6088.00</i>
										</strong>
										</div>
										<div class="operate">
											<a href="javascript:void(0);" class="sui-btn btn-bordered">加入购物车</a>
										</div>
									</div>
									<div class="list-wrap">
										<div class="p-img">
											<img src="/static/img/_/part03.png" />
										</div>
										<div class="attr">
											<em>Apple苹果iPhone 6s (A1699)</em>
										</div>
										<div class="price">
											<strong>
											<em>¥</em>
											<i>6088.00</i>
										</strong>
										</div>
										<div class="operate">
											<a href="javascript:void(0);" class="sui-btn btn-bordered">加入购物车</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="profile" class="tab-pane">
							<p>推荐品牌</p>
						</div>
					</div>
				</div>
				<div class="fr detail">
					<div class="tab-main intro">
						<ul class="sui-nav nav-tabs tab-wraped">
							<li class="active">
								<a href="#one" data-toggle="tab">
									<span>商品介绍</span>
								</a>
							</li>
							<li>
								<a href="#two" data-toggle="tab">
									<span>规格与包装</span>
								</a>
							</li>
							<li>
								<a href="#three" data-toggle="tab">
									<span>售后保障</span>
								</a>
							</li>
							<li>
								<a href="#four" data-toggle="tab">
									<span>商品评价</span>
								</a>
							</li>
							<li>
								<a href="#five" data-toggle="tab">
									<span>手机社区</span>
								</a>
							</li>
						</ul>
						<div class="clearfix"></div>
						<div class="tab-content tab-wraped">
							<div id="one" class="tab-pane active">
								<ul class="goods-intro unstyled">
									<li>分辨率：1920*1080(FHD)</li>
									<li>后置摄像头：1200万像素</li>
									<li>前置摄像头：500万像素</li>
									<li>核 数：其他</li>
									<li>频 率：以官网信息为准</li>
									<li>品牌： Apple</li>
									<li>商品名称：APPLEiPhone 6s Plus</li>
									<li>商品编号：1861098</li>
									<li>商品毛重：0.51kg</li>
									<li>商品产地：中国大陆</li>
									<li>热点：指纹识别，Apple Pay，金属机身，拍照神器</li>
									<li>系统：苹果（IOS）</li>
									<li>像素：1000-1600万</li>
									<li>机身内存：64GB</li>
								</ul>
								<div class="intro-detail">
									<img src="/static/img/_/intro01.png" />
									<img src="/static/img/_/intro02.png" />
									<img src="/static/img/_/intro03.png" />
								</div>
							</div>
							<div id="two" class="tab-pane">
								<p>规格与包装</p>
							</div>
							<div id="three" class="tab-pane">
								<p>售后保障</p>
							</div>
							<div id="four" class="tab-pane">
								<p>商品评价</p>
							</div>
							<div id="five" class="tab-pane">
								<p>手机社区</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--like-->
			<div class="clearfix"></div>
		</div>
	</div>
	@endsection
	
	
	
<script type="text/javascript" src="/static/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
	//收藏
	$(document).on("click","#show",function(){
		alert(11);
	})
	//给id为add绑定点击事件  ===点击 +
        $(document).on("click","#add",function(){
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
        })

        //给id为less绑定点击事件  ===点击 -
        $(document).on("click","#less",function(){

            var buy_number=parseInt($("#buy_number").val());
            //判断购买数量是否小于1
            if(buy_number<=1){
                $("#buy_number").val(1);//购买数量<=1
            }else{
                buy_number=buy_number-1;//购买数量-1
                $("#buy_number").val(buy_number);//购买数量-1后的值
            }
        })

        //给id为buy_number绑定失去焦点事件 ===失去焦点
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
        })

        $(document).on("click","#addcart",function(){
            var goods_id=$("#goods_id").val();
            var user_id=$("#user_id").val();
            var buy_number=parseInt($("#buy_number").val());
        $.ajax({
            url: "/cart/cartlist/goods_id="+{{ $goods['goods_id'] }},
            type: "post",
            data:{goods_id:goods_id,buy_number:buy_number,user_id:user_id},
            dataType: "json",
            success: function(d){
                // console.log(d)
                if(d.errno==0){
                	alert(d.msg)
                	location.href ="/cart"
                }
            }
        })
    });
</script>
	
