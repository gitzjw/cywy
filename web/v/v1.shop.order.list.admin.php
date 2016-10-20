<?php 
$speObj = new ShopSpeUserController();
$speRes = $speObj->getShopSpeUserOpenId();
if(empty($speRes) || $speRes['wType']=='1'){
	die('您不是系统管理员，无权查看');exit();
}
?>
<section class="goods_order" id="mainList">

</section>

<div class="s_more" id="loadPage">
	<a style="" class="more_img" title="更多动态" href="javascript:void(0)">加载更多内容</a>
</div>

<script>
var _city = '<?php echo $speRes['city'];?>';
var _type = '<?php echo $speRes['wType'];?>';
</script>
<script src="<?php echo JS_PATH;?>shop.order.list.admin.js?v=0.1"></script>