<?php 
if(0){
?>
<style>
<!--
.prompt {
	margin: 60% auto 0;
	width: 250px;
	height: 100px;
	text-align: center;
	line-height: 22px;
}

.prompt p {
	margin-bottom: 15px;
}

.prompt span {
	color: #f1be00;
	text-decoration: underline;
	font-weight: bold;
}
-->
</style>
<div class="prompt">
<p>暂未开放。</p>
</div>
<?php 
}else{
?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>swiper3.1.0.min.css" type="text/css" />
<div class="qxgl"> <img src="<?php echo IMG_PATH;?>mjd_1.jpg" width="100%" />
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide blue-slide ">
						<div class="mjd_pl">
							<dl>
								<dt><img src="<?php echo IMG_PATH;?>pl_2.JPG" /></dt>
								<dd class="mjd_bt">露西宠物生活馆</dd>
								<dd>何小瑶（北京）</dd>
							</dl>
							<p>店里的剪刀一直都是赵师傅给磨，以前总要抽出半天时间跑到珠市口赵师傅的店里，现在可以直接在宠业无忧平台上下单了，真是方便，赵师傅手艺京城第一棒！！！</p>
						</div>

					</div>
					<div class="swiper-slide red-slide">
						<div class="mjd_pl">
							<dl>
								<dt><img src="<?php echo IMG_PATH;?>pl_1.jpg" /></dt>
								<dd class="mjd_bt">哈尼萌宠</dd>
								<dd>高峰（上海）</dd>
							</dl>
							<p>找到一个手艺好的磨剪刀老师傅，真心不容易，尤其是像跟一样经常打比赛的小伙伴。强烈推荐北京的老手艺人赵师傅，我已经坚持用了5年了，每次发快递往返4天左右，挺方便的。</p>
						</div>
					</div>
					<div class="swiper-slide red-slide">
						<div class="mjd_pl">
							<dl>
								<dt><img src="<?php echo IMG_PATH;?>pl_3.jpg" /></dt>
								<dd class="mjd_bt">Model麻豆宠物</dd>
								<dd>陈晨（深圳）</dd>
							</dl>
							<p>我在深圳，自从朋友介绍赵师傅后，我就一直用邮寄的方式，让赵师傅给磨。一直都很满意，剪刀是咱美容师的立身之本，老手艺人，磨技精湛，我给赵师傅代言~哈哈</p>
						</div>
					</div>
					<div class="swiper-slide red-slide">
						<div class="mjd_pl">
							<dl>
								<dt><img src="<?php echo IMG_PATH;?>pl_4.jpg" /></dt>
								<dd class="mjd_bt">派多格方庄店</dd>
								<dd>奶糕爸爸（北京）</dd>
							</dl>
							<p>赵师傅绝对是磨剪刀领域的匠人，去年过年不回家，我留店里看店，正月初三给赵师傅打电话，老师傅竟然说：没问题，拿过来吧，可以磨。当时我就惊呆了…</p>
						</div>
					</div>
				</div>
				<div class="swiper-pagination">
				</div>
			</div>

			<div class="background1 height1"></div>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="70%"><span>磨剪刀</span>直剪、弯剪、牙剪</td>
					<td>20元/个</td>
				</tr>
				<tr>
					<td><span>磨刀头</span>大刀头 小刀头 </td>
					<td>20元/个</td>
				</tr>
			</table>
			<div class="mjd_ts">*本服务仅支持邮寄方式
			</div>
		</div>
<div class="Buy_btn4 submit_order" style="padding-bottom:0;margin-bottom:20px;"> <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo APPID;?>&redirect_uri=http%3A%2F%2Fweb.chongyewuyou.com%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.mjd.order&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect">立即下单</a> </div>

	<script type="text/javascript" src="<?php echo JS_PATH;?>swiper3.1.0.min.js"></script>
		<script type="text/javascript">
			var mySwiper = new Swiper('.swiper-container', {
				loop: true,
				autoplay: 3000,
				pagination: '.swiper-pagination',
				paginationClickable: true,
			});
		</script>
<!--<div class="Buy_btn4 submit_order" style="padding-bottom:0"> <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo APPID;?>&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.mjd.order&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect">立即预约</a> </div>-->
<!--<div class="order_ddlb">您目前没有订单<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo APPID;?>&redirect_uri=http%3A%2F%2Fmgs.momoday.net%2Fe%2Fwechat%2Fwechat.callback.php%3Ftpl%3Dv1.mjd.order.list&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect">查看我的订单</a> >>></div>-->
<!--<div class="bddh">-->
<!--  <p> <strong>预约电话</strong><span>4007-007-580</span></p>-->
<!--  <div><a href="tel:4007007580"><img src="<?php echo IMG_PATH;?>d_5.png">电话预约</a></div> </div>-->
<?php 
}
?>