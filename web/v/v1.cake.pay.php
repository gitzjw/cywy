<?php 
Run::show_msg('蛋糕业务维护中','1','?tpl=v1.cake.shop');
$obj = new CakeShopController();
$cakeShopRes = $obj->getCakeShopUid();
if(empty($cakeShopRes)){
	Run::show_msg('','1','?tpl=v1.cake.shop');
}

$cProObj = new CakeProController();
$res = $cProObj->getCakeProDetail();
?>
<link rel="stylesheet" href="<?php echo JS_PATH;?>mic-date/css/mobiscroll.custom-2.17.0.min.css" type="text/css" />
<dl class="cake_order">
	<dt><img src="<?php echo $res['listImgPath'];?>" height="100px;" width="100px;"/></dt>
	<dd class="cake_bt"><?php echo $res['title'];?></dd>
	<dd>价格：<span>￥<?php echo $res['nPrice'];?></span></dd>
</dl>
<div class="background1 height1"></div>
<section>
<ul class="order_dz">
	<li><img src="<?php echo IMG_PATH;?>icon_xd_fwxm.png"><span>配送到</span><strong><a href="javascript:void(0);" id="sendtype" onclick="showDiv('id_div_sendtype')">请选择配送地址</a></strong></li>
	<!--输入收货人的电话请输入收货人的电话请输入收货人的电话请输入收货人的电话请输入收货人的电话-->
	<li><img src="<?php echo IMG_PATH;?>icon_xd_fwdz.png"><span id="id_ads">地址</span><strong	class="dz"><textarea name="address" id="id_inp_ads" placeholder="请输入送货地址"></textarea> </strong></li>
	<li><img src="<?php echo IMG_PATH;?>icon_xd_gjtd.png"><span id="id_name">收货人</span><strong><input type="text" name="name" id="id_inp_name"  placeholder="请输入收货人姓名"></strong></li>
	<li><img src="<?php echo IMG_PATH;?>icon_xd_lxdh.png"><span id="id_tel">电话</span><strong><input type="number" name="tel" id="id_inp_tel"  placeholder="请输入收货人的电话"></strong></li>
	<li><img src="<?php echo IMG_PATH;?>icon_xd_xz.png"><span>收货时间</span><strong><input id="petDate" name="rTime" type="text" placeholder="请选择收货时间"></strong></li>
	<li class="background1 height1"></li>
	<li><img src="<?php echo IMG_PATH;?>icon_xd_yjfk.png"><span>宠物名字</span><strong><input type="text" name="pname" placeholder="请输入宠物名字"></strong></li>
	<li><img src="<?php echo IMG_PATH;?>icon_xd_cwpz.png"><span>宠物性别</span><strong><a href="javascript:void(0);" id="psex" onclick="showDiv('id_div_sex')">请选择性别</a></strong></li>
	<li><img src="<?php echo IMG_PATH;?>icon_xd_xz.png"><span>宠物年龄</span><strong><input name="pdate" type="text" placeholder="请输入宠物年龄"></strong></li>

</ul>
</section>
<div class="Buy_btn4 submit_order"><a href="javascript:void(0)" id="btn_s">立即下单</a></div>

<div class="tc_fwxm" id="id_div_sendtype">
	<ul>
		<li class="tc_bt">选择服务方式</li>
		<li _v="2"><a href="javascript:void(0);"><?php echo $cakeShopRes['shopName'];?></a></li>
		<!--<li _v="1"><a href="javascript:void(0);">个人</a></li>-->
	</ul>
	<a href="javascript:void(0);" onclick="hideDiv();">取消</a>
</div>

<div class="tc_fwxm" id="id_div_sex">
	<ul>
		<li class="tc_bt" _v="">选择性别</li>
		<li _v="1"><a  href="javascript:void(0);">公</a></li>
		<li _v="0"><a  href="javascript:void(0);">母</a></li>
	</ul>
	<a href="javascript:void(0);" onclick="hideDiv();">取消</a>
</div>


<div class="box" id="t_box"></div>


<script src="<?php echo JS_PATH;?>mic-date/js/mobiscroll.custom-2.17.0.min.js"></script>
<script type="text/javascript">
var _defaultAds = '<?php echo $cakeShopRes['shopAddress'];?>';
var _defaultName = '<?php echo $cakeShopRes['shopName'];?>';
var _defaultTel = '<?php echo $cakeShopRes['shopTel'];?>';
var _cpId = '<?php echo $res['id'];?>';
var _cpName = '<?php echo $res['title'];?>';
var _cpImg = '<?php echo $res['listImgPath'];?>';
</script>
<script src="<?php echo JS_PATH;?>cake.pay.js"></script>