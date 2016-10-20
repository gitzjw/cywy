<?php 
$obj = new CakeShopController();
$cakeShopRes = $obj->getCakeShopUid();
if(empty($cakeShopRes)){
	Run::show_msg('','1','?tpl=v1.cake.shop');
}
?>
<img src="http://img.chongyewuyou.com:4869/4a4f9954f8a9b8180ee7728c38d2acb5" width="100%">
<p class="jf_nav">
	<a href="?tpl=v1.cake.order.list"><img src="<?php echo IMG_PATH;?>jf_dhjl.jpg" ><strong>我的订单</strong></a> 
	<a href="?tpl=v1.cake.income"><img src="<?php echo IMG_PATH;?>jf_tb.jpg" ><strong>我的收入</strong></a>
</p>
<div class="background1 height1"></div>
<ul class="cake_l " id="cakeMainList">
</ul>

<!--<div class="s_more" id="loadPage">
	<a style="" class="more_img" title="更多动态" href="#">加载更多内容</a>
</div>

--><script src="<?php echo JS_PATH;?>cake.main.js"></script>