<?php
$obj = new CakeShopController();
$cakeShopRes = $obj->getCakeShopUid();
if(empty($cakeShopRes)){
	Run::show_msg('','1','shop.php?tpl=v1.shop.shop');
}elseif(empty($cakeShopRes['shopInvCode'])){
	Run::show_msg('','1','shop.php?tpl=v1.shop.shop');
}
?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>swiper3.1.0.min.css" type="text/css" />

<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide blue-slide"><a href="javascript:void(0)"><img src="http://img.momopet.cn:4869/2f784122cc67b45a8ad66b6af04ef023" width="100%"></a></div>
<!--        <div class="swiper-slide red-slide"><a href="http://mgs.momoday.net/s/20160126/"><img src="http://img.momopet.cn:4869/a25b6394a3c1a295b052cd96bafc00c1" width="100%"></a></div>-->
    </div>
    <div class="swiper-pagination">
    </div>
</div>

<p class="jf_nav">
<span>
	<a href="shop.php?tpl=v1.shop.order.list"><img src="<?php echo IMG_PATH;?>jf_dhjl.png" ><strong>我的订单</strong></a>
</span>
<span> 
	<a href="shop.php?tpl=v1.shop.demand"><img src="<?php echo IMG_PATH;?>xuqiu.jpg" ><strong>我的需求</strong></a>
</span>
</p>
<div class="background1 height1"></div>
<ul class="cake_l " id="mainLi">
  
</ul>

<script src="<?php echo JS_PATH;?>shop.index.js?v=1.1"></script>

<script type="text/javascript" src="<?php echo JS_PATH;?>swiper3.1.0.min.js"></script>
<script type="text/javascript">
  var mySwiper = new Swiper('.swiper-container',{
    loop: true,
	autoplay: 3000,
	pagination: '.swiper-pagination',
    paginationClickable: true,
  });
</script>
