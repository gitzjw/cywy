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
        <!--
    	<div class="swiper-slide blue-slide"><a href="shop.php?tpl=v1.shop.goods.list&i=286"><img   src="http://img.momoday.net:4869/c5715c185fdc14ef18034043ddfe8600" width="100%"></a></div>
        
        <div class="swiper-slide blue-slide"><a href="shop.php?tpl=v1.shop.goods.list&i=286"><img src="http://img.momoday.net:4869/2f784122cc67b45a8ad66b6af04ef023" width="100%"></a></div>
        
        <div class="swiper-slide blue-slide"> <a href="shop.php?tpl=v1.shop.goods.list&i=286"><img  src="http://img.momoday.net:4869/c8fe4bd6c47247317b0f1faa44c41fab" width="100%"></a></div>
    -->
    <?php
        $obj = D('ShopMainInfo');
        $res = $obj->getShopMainPics();


        if(!empty($res)){
            foreach ($res as $key => $value) {
                if(intval($value['status']) === 1){
                    $_linkUrl = $value['linkUrl'];
                    if(strpos($_linkUrl,'.')){

                    }else{
                        $_linkUrl = 'http://img.chongyewuyou.com:4869/'.$_linkUrl;
                    }
                ?>
            <div class="swiper-slide blue-slide"><a href="<?php echo $_linkUrl;?>"><img   src="http://img.chongyewuyou.com:4869/<?php echo $value['linkPic'];?>" width="100%"></a></div>
                <?php
                }
            }
        }
    ?>

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

<div class="background1 height1"></div>
		<div class="gifts">
			<h2>本月福利</h2>
			<div class="gifts_g">
               
				<p>① 满1000元，配赠价值116元商品 <br />② 满2000元，配赠价值356元商品<br />③ 满3000元，配赠价值830元商品<br />④ 满5000元，配赠价值1440元商品<br />⑤ 满10000元，配赠价值2880元商品<br /></p>
				<hr />
				<p>详情请咨询商务经理。<br />
				</p>
			</div>
			<div class="gifts_r">
             <img  src="http://img.chongyewuyou.com:4869/092458059ce61e7d90a8f82a4d5bf1ed"/>
			</div>

		</div>


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
