<link rel="stylesheet" href="<?php echo CSS_PATH;?>swiper3.1.0.min.css" type="text/css" />
<style>
.swiper-container {
	width: 100%;
	height: 50px;
	margin: 0px auto;
	border-bottom:#c3c3c3 solid 1px;
	position:fixed;
	top:0;
	left:0;
}
.swiper-slide {
	text-align: center;
	font-size: 18px;
	background: #f1f1f1;
	width: 22%;
	/* Center slide text vertically */
        display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}
.swiper-slide a {
	display:block;
	padding:5px 10px;
}
.goods_active a {
	background:#f1be00;color:#fff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;
}
.swiper-scrollbar {
	background:none;
}
</style>

<div id="MainShopProListDiv">
	<!-- 头部列表 -->
	<!-- Swiper -->
	<div class="swiper-container">
	    <div class="swiper-wrapper" id="topList">
	        <!--<div class="swiper-slide goods_active"><a href="#">主粮</a></div>
	        <div class="swiper-slide "><a href="#">零食</a></div>
	     --></div>
	     <!-- Add Scrollbar -->
	     <div class="swiper-scrollbar" ></div>
	</div>
	<!-- 头部列表 结束 -->
	
	<!-- 商品列表 -->
	<div class="goods_zong">
		<div class="goods_left">
			<ul id="leftList">
				<!--<li>宠物吃的4</li>
				<li class="goods_lact">宠物吃的</li>
			--></ul>
		</div>
		<div class="goods_right">
			<div class="table" id="rightList">
				<!--<a href="#">
				<img src="<?php echo IMG_PATH;?>sign_3.jpg">
				<dl class="goods_mc">
				<dt>新鲜狗粮新鲜狗粮新鲜狗粮</dt>
				<dd>已售200单</dd>
				<dd><strong>￥128</strong><p><span class="minus"></span> <span class="shuzi">11</span><span class="add"></span></p></dd>
				</dl>
				</a>
			--></div>
		</div>
	</div>
	<!-- 商品列表 结束 -->
	
	<!-- 购物车 -->
	<div class="car">
		<p onclick="$('#goodsCar').show();$('#carbox').show();">
			<img src="<?php echo IMG_PATH;?>icon_cart.png"><span id="totalPrice">￥0</span> <!--<strong id="marketingShow"></strong>-->
		</p>
		<a href="javascript:void(0)" onclick="account();">去结算</a>
		<!--<a href="javascript:void(0)" onclick="alert('春节放假休息，2016年02月14日恢复下单！');">去结算</a>-->
	</div>
	
	<div class="goods_car" id="goodsCar">
		<h2><span id="totalNum">共0件<strong>(满1000元起订)</strong></span> <a href="javascript:void(0);" onclick="clearCartList()">清空购物车</a></h2>
		<ul id="goodsCarList">
			<!--
			<li> 
				<strong class="goods_bt">深海宠物</strong> 
				<p>
					<span class="minus"></span> 
					<span class="shuzi">11</span>
					<span class="add"></span>
				</p>
				<strong class="goods_jg">￥1221</strong>
			</li>
			-->
		</ul>
	</div>
	
	<div class="box" id="carbox" onclick="$('#goodsCar').hide();$('#carbox').hide();"></div>

</div>

<!-- 购物车 结束 -->

<!-- 结算 开始 -->

<div style="display:none" id="orderEndListPay">
	<div class="goods_fanhui"><a href="#" onclick="$('#MainShopProListDiv').show();$('#orderEndListPay').hide();">返回</a></div>
	<dl class="goods_address">
		<dd id="rShopName"></dd>
		<dt id="rName"></dt>
		<dd id="rAddress"></dd>
	</dl>
	<div class="background1 height1"></div>
	<ul><li></li></ul>
	<div class="goods_car1" >
		<ul id="orderEndListUl">
			<!--<li> <strong class="goods_bt">深海宠物深海宠物深海宠物深海宠物深海宠物深海宠物</strong>  <span>￥1211</span><strong class="goods_jg">X 5</strong></li>-->
		</ul>
		<ul id="zpListUl">
			<!--<li> <strong class="goods_bt"><span>【赠品】</span>深海宠物深海宠物深海宠物深海宠物深海宠物深海宠物</strong>  <span class="through">￥12111.11</span><strong class="goods_jg">X 5</strong></li>
		--></ul>
		<div class="background1 height1"></div>
		<ul class="goods_zj">
			<li> <strong class="goods_bt">合计</strong>  <span id="orderEndOPrice">￥0</span></li>
			<!--
			<li> <strong class="goods_bt">优惠<div class="jxzx">（仅限在线支付）</div></strong>  <span id="orderEndDprice">￥0</span></li>
			-->
			<li> <strong class="goods_bt">配送费</strong>  <span id="psf" class="throu">￥0</span></li>
			<li> <strong class="goods_bt">实收</strong>  <span id="orderEndNPrice">￥0</span></li>
		</ul>
<!--		<p>货到付款</p>-->
		<!--<div class="goods_yh"><span>优惠说明</span></div>-->
		<div class="yhsm" id="yhsmHtml">
		</div>
		</div>

	<div class="car">
		<p>
			<span id="orderEndTotalMoney">总计￥0</span> <!--<strong id="orderEndMarketing"></strong>-->
		</p>
		<a href="#" id="payOrder">确认下单</a>
	</div>
	
	<div class="popup">
	  <h4>优惠说明<br><br>
使用在线支付，即可享受优惠。<br>
仅限每月首单。</h4>
	  <p id="discountNoteHtml"></p>
	  <a href="javascript:void(0);" class="sign_aniu">确定</a> 
	 </div>
	 
	 <div class="zffs">
		<h2>支付方式选择 </h2>
	  <ul>
	  	<li><img src="<?php echo IMG_PATH;?>icon_zf_wx.png"/><p>在线支付（每月首单享优惠）</p><a href="javascript:void(0)" id="onlinePay">￥00</a></li>
	  	<li style="display:none" id="xianxiashouqian"><img src="<?php echo IMG_PATH;?>icon_zf_xianxia.png" /><p>货到付款（无优惠）</p><a href="javascript:void(0)" id="downlinePay">￥00</a></li>
	  </ul>
	</div>
	 
	<div class="box " style=" z-index:25"></div>
</div>

<!-- 结算 结束-->

<script src="<?php echo JS_PATH;?>shop.goods.list.js?v=1.9.4"></script>
<!-- Swiper JS -->
<script src="<?php echo JS_PATH;?>swiper3.1.0.min.js"></script>
<!-- Initialize Swiper -->
<script>
var swiper = new Swiper('.swiper-container', {
        scrollbarHide: true,
        slidesPerView: 'auto',
        grabCursor: true,
});
$(".goods_yh span").click(function(){$(".box").show();	 $(".popup").show(); 	})
$(".sign_aniu").click(function(){$(".box").hide();$(".popup").hide();	});	
$(".box").click(function(){
	$(".box").hide();
     $(".zffs").hide(); 		
	})
</script>
