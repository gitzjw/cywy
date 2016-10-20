<?php 
$obj = new CakeOrderController();
$_id = Run::req('i');
$res = $obj->getCakeOrderId($_id);
if(empty($res)){
	Run::show_msg('没有此订单详情');
}
?>
<dl class="cake_orderd">
<dt> <img src="<?php echo $res['cpImg'];?>"  /></dt>
<dd><?php echo $res['createTime'];?></dd>
<dd><?php echo $res['cpName'];?></dd>
<dd>￥<?php echo $res['payMoney'];?></dd>
</dl>
<div class="background1 height1"></div>
<section>
<ul class="order_dz">
<li><img src="<?php echo IMG_PATH;?>icon_xd_fwdz.png"><span>地址</span><strong class="dz"><?php echo $res['oAddress'];?></strong></li>
<li><img src="<?php echo IMG_PATH;?>icon_xd_gjtd.png"><span>姓名</span><strong ><?php echo $res['oName'];?></strong></li>
<li><img src="<?php echo IMG_PATH;?>icon_xd_lxdh.png"><span>电话</span><strong ><?php echo $res['oTel'];?></strong></li>
<li class="background1 height1"></li>
<li><img src="<?php echo IMG_PATH;?>icon_xd_fk.png"><span>订单金额</span><strong class="cake_color">￥<?php echo $res['payMoney'];?></strong></li>

<li><img src="<?php echo IMG_PATH;?>icon_xd_wddd.png"><span>订单状态</span><strong ><?php echo $obj->getStatusText($res['status']);?></strong></li>
<li><img src="<?php echo IMG_PATH;?>icon_xd_fwsj.png"><span>送货时间</span><strong ><?php echo $res['rTime'];?></strong></li>
<li><img src="<?php echo IMG_PATH;?>d_5.png"><span>客服电话</span><strong >4007-007-580</strong></li>

</ul>
</section>