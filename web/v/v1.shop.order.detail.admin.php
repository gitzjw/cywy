<?php 
$_id = Run::req('i');
if($_id){
	$speObj = new ShopSpeUserController();
	$speRes = $speObj->getShopSpeUserOpenId();
	$obj = new ShopOrderController();
	$orderRes = $obj->getShopOrderDetail($_id);
	$orderChiRes = $obj->getShopOrderChildrenDetail($_id);
	$orderStsRes = $obj->getShopOrderHistoryDetail($_id);
}else{
	Run::show_msg();
}
?>

<h3 class="ddzt"><img src="<?php echo IMG_PATH;?>icon_xd_fwsj.png" width="23">订单状态</h3>
<ul class="dd_lc">
<?php 
foreach ($orderStsRes as $k=>$v){		
	echo '<li class="hei"> <span>'.$obj->getStatusDesc($v['oStatus']).' '.$v['oUser'].' '.Run::getFormatDate($v['createTime'],'m-d H:i').'</span><div class="hidden"></div></li>';
}
?>
</ul>
<div class="background1 height1"></div>

<dl class="goods_address">
<dt><?php echo $orderRes['oShopName'];?></dt>
<dt><?php echo $orderRes['oName'];?>&nbsp;&nbsp;<a href="tel:<?php echo $orderRes['oTel'];?>"><?php echo $orderRes['oTel'];?></a></dt>
<dd><?php echo $orderRes['oAddress'];?></dd>
</dl>
<div class="background1 height1"></div>
<ul>
<li></li>

</ul>


<div class="goods_car1 qrdd" >
<ul class="qrdd_list" id="detailList">
<?php 
// class="qrdd_act" 选中
foreach ($orderChiRes as $k=>$v){		
	echo '<li _odi="'.$v['id'].'" _pi="'.$v['pId'].'"> <strong class="goods_bt"><a href="shop.php?tpl=v1.shop.goods.d&i='.$v['pId'].'">'.$v['pTitle'].'</a></strong>  <div><span>￥'.$v['tPrice'].'</span><strong class="goods_jg">X '.$v['eNum'].'</strong></div></li>';
}
?>
</ul>
<ul class="goods_zj">
<li > <strong class="goods_bt">合计</strong>  <span>￥<?php echo $orderRes['oMoney'];?></span></li>
<li> <strong class="goods_bt">优惠</strong>  <span>￥<?php echo $orderRes['dMoney'];?></span></li>
<li> <strong class="goods_bt">实收</strong>  <span>￥<?php echo $orderRes['nMoney'];?></span></li>
</ul>
<!--<p>货到付款</p>-->
<!--<div class="goods_yh"><span>优惠说明</span></div>-->
<?php 
if(empty($orderRes['payCode'])){
?>
<p>货到付款</p>
<div class="goods_yh"><span>优惠说明</span></div>
<?php 
}else{
echo '<p>在线支付</p>
<div class="goods_yh"><span>优惠说明</span></div>';	
}
?>
</div>

<div class="popup">
  <h4>优惠说明</h4>
	  <p>无</p>
  <a href="#" class="sign_aniu">确定</a> 
</div>


<div class="operation">
<?php 
if($orderRes['oStatus']=='1'){
	echo '<a href="#" id="quitBtn">取消</a><a href="#" id="yesBtn" class="operation_a" _s="1">确认</a>';
}elseif($orderRes['oStatus']=='2'){
	echo '<a href="#" id="yesBtn" class="operation_a good_width" _s="2">配送中</a>';
}elseif($orderRes['oStatus']=='3'){
	
}elseif($orderRes['oStatus']=='4'){
	if(isset($speRes['wType']) && $speRes['wType']=='4'){
		echo '<a href="#" id="yesBtn" class="operation_a good_width" _s="4">收款成功</a>';
	}
}elseif($orderRes['oStatus']=='5'){
	if(isset($speRes['wType']) && $speRes['wType']=='4'){
		echo '<a href="#" id="yesBtn" class="operation_a good_width" _s="5">完成订单</a>';
	}
}elseif($orderRes['oStatus']=='6'){
	
}
?>
	
	<!--<a href="#" class="operation_a good_width">确定</a>-->
</div>

<script  type="text/javascript">
$(document).ready(function(){$(".goods_yh span").click(function(){		$(".box").show();         $(".popup").show();});$(".sign_aniu").click(function(){		$(".box").hide();         $(".popup").hide();})})
</script>
<script src="<?php echo JS_PATH;?>shop.order.detail.admin.js?v=0.1"></script>
<div class="box " style=" z-index:25">
</div>