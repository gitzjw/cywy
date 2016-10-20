<?php
Run::c('v1.mjd.order.list');
$oObj = new RepairOrderController();
$user = $oObj->getUserDetail();
$oRes = $oObj->getRepairOrderUid($user['id']);
$ohObj = new RepairOrderHistoryController();
$odObj = new RepairOrderDetailController();
$wObj = C('WebType');
$wRes = $wObj->getWebTypeAll('1');

if(!$oRes){
	echo '<p class="juzhong">您目前没有订单。</p>';
}else{
foreach ($oRes as $k=>$v){
	$hisRes = $ohObj->getRepairOrderHistoryOid($v['id']);
	$odRes = $odObj->getRepairOrderDetailOidList($v['id'],'1');
?>
<section class="or_list">
	<ul class="order_list">
		<li><label>时间：</label><span><?php echo $v['roCreateDate'];?></span></li>
		<li><label>服务方式：</label><span><?php echo $wRes[$v['wType']];?></span></li>
		<?php 
		foreach ($odRes as $ok=>$ov){
			if(!$ok){
				echo "<li><label>数量：</label><span>{$wRes[$ov['wType']]} {$ov['odNum']}把</span></li>";
			}else{
				echo "<li><label></label><span>{$wRes[$ov['wType']]} {$ov['odNum']}把</span></li>";
			}
		}
		?>
	</ul>
	<dl class=" order_dd">
		<dt><label>订单状态：</label> <span><?php echo Run::getFormatDate($v['roCreateDate'],'Y年m月d日');?><strong></strong></span></dt>
		<?php 
		foreach ($hisRes as $hk=>$hv){
			echo "<dd>{$hv['createTime']} {$hv['ohText']}</dd>";
		}
		?>
	</dl>
</section>
<?php 
}
}
?>

<script type="text/javascript">
$(".order_dd dt ").click(function(){

	 if($(this).siblings("dd").is(":hidden")){
		
			$(this).find("strong").addClass("bzzx-but-cur").end();
			$(this).siblings("dd").show();
			}
			else
			{$(this).find("strong").removeClass("bzzx-but-cur").end();
			$(this).siblings("dd").hide();
			}

  })
</script>