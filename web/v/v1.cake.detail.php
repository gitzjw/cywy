<link rel="stylesheet" href="<?php echo CSS_PATH;?>swiper3.1.0.min.css" type="text/css" />
<style>
.swiper-container {width: 100%;}  
.swiper-wrapper img{ width:100%;}
.swiper-pagination-bullet-active{background:#fff;}
</style>
<?php 
$obj = new CakeProController();
$res = $obj->getCakeProDetail();
?>
<div class="swiper-container">
    <div class="swiper-wrapper">
    <?php 
    $_a = explode('|', $res['imgPath']);
    foreach ($_a as $value) {
    	echo '<div class="swiper-slide red-slide"><img src="'.$value.'"  width="100%"></div>';
    }
    ?>
    </div>
    <div class="swiper-pagination">
    </div>
</div>
<div class="cake_gou">
<p><strong>￥<?php echo $res['nPrice']?></strong>
<span>月销<?php echo $res['dNum'];?>笔</span></p>
<a href="?tpl=v1.cake.pay&i=<?php echo $res['id'];?>">立即购买</a>
</div>
<div class="cake_gou">
<?php echo $res['content'];?>
</div>




<script type="text/javascript" src="<?php echo JS_PATH;?>swiper3.1.0.min.js"></script>
<script type="text/javascript">
  var mySwiper = new Swiper('.swiper-container',{
    loop: true,
	autoplay: 3000,
	pagination: '.swiper-pagination',
    paginationClickable: true,
  });
</script>