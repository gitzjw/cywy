<?php 
$obj = new ShopOrderController();
$speObj = new ShopSpeUserController();
$speRes = $speObj->getShopSpeUserOpenId();
if(empty($speRes)){
	die('没有绑定，无法查看');exit;
}
$res = $speObj->getBdOrder($speRes['uId']);
?>
<section class="goods_order" id="mainList">
<a href="javascript:void(0);">
	<dl>
		<dt>
		商务：<strong><b><?php echo $speRes['sName'];?></b></strong> 店铺订单<br>
		</dt>
	</dl>
</a>
<?php 
foreach ($res as $k=>$v){
?>
<a href="shop.php?tpl=v1.shop.order.detail.bd&i=<?php echo $v['id'];?>"><dl>
	<dt>		
		<strong><?php echo $obj->getStatusDesc($v['oStatus']);?></strong>
		<span><?php echo $v['createTime'];?></span>
		<br /><span>店主：</span><?php echo $v['oName'];?>
		<br /><span>店名：</span><?php echo $v['oShopName'];?>
		<br /><span>地址：</span><?php echo $v['oAddress'];?>		
	</dt>
	<dd></dd>
	<dd class="goods_r">共份<?php echo $v['totalNum'];?>，总价<strong>￥<?php echo $v['oMoney'];?></strong>，实付<strong>￥<?php echo $v['nMoney'];?></strong></dd>
	</dl>
</a>
<div class="background1 height1"></div>
<?php 
}
?>	
</section>

