<?php 
$_id = Run::req('i');
if($_id){
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
<dt><?php echo $orderRes['oName'];?>&nbsp;&nbsp;<?php echo $orderRes['oTel'];?></dt>
<dd><?php echo $orderRes['oAddress'];?></dd>
</dl>
<div class="background1 height1"></div>
<ul>
<li></li>

</ul>
<div class="goods_car1" >
<ul>
<?php 
foreach ($orderChiRes as $k=>$v){
	if($v['odStatus']=='2'){
		//$_tmpStr = '无货';
		echo '<li> <strong class="goods_bt">'.$v['pTitle'].'</strong>  <span>无货</span><strong class="goods_jg"></strong></li>';
	}else{
		//$_tmpStr = '';
		echo '<li> <strong class="goods_bt">'.$v['pTitle'].'</strong>  <span>￥'.$v['tPrice'].'</span><strong class="goods_jg">X '.$v['eNum'].'</strong></li>';
	}
}
?>
</ul>
<ul class="goods_zj">
<li > <strong class="goods_bt">合计</strong>  <span>￥<?php echo $orderRes['oMoney'];?></span></li>
<li> <strong class="goods_bt">优惠</strong>  <span>￥<?php echo $orderRes['dMoney'];?></span></li>
<li> <strong class="goods_bt">实收</strong>  <span>￥<?php echo $orderRes['nMoney'];?></span></li>
</ul>
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
