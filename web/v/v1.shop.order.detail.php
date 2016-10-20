<?php 
$_id = Run::req('i');
if($_id){
	$obj = new ShopOrderController();
	$orderRes = $obj->getShopOrderDetail($_id);
	$orderChiRes = $obj->getShopOrderChildrenDetail($_id);
	$orderStsRes = $obj->getShopOrderHistoryDetail($_id);
}else{
	Run::show_msg();
}
?>

<h3 class="ddzt"><img src="<?php echo IMG_PATH;?>icon_xd_fwsj.png" width="23">订单状态</h3>
<ul class="dd_lc">
<?php 
foreach ($orderStsRes as $k=>$v){		
	echo '<li class="hei"> <span>'.$obj->getStatusDesc($v['oStatus']).' '.$v['oUser'].' '.Run::getFormatDate($v['createTime'],'m-d H:i').'</span><div class="hidden"></div></li>';
}
?>
</ul>
<div class="background1 height1"></div>

<dl class="goods_address">
<dt><?php echo $orderRes['oShopName'];?></dt>
<dt><?php echo $orderRes['oName'];?>&nbsp;&nbsp;<?php echo $orderRes['oTel'];?></dt>
<dd><?php echo $orderRes['oAddress'];?></dd>
</dl>
<div class="background1 height1"></div>
<ul>
<li></li>

</ul>
<div class="goods_car1" >
<ul>
<?php 
foreach ($orderChiRes as $k=>$v){
	if($v['odStatus']=='2'){
		//$_tmpStr = '无货';
		echo '<li> <strong class="goods_bt">'.$v['pTitle'].'</strong>  <span>无货</span><strong class="goods_jg"></strong></li>';
	}else{
		//$_tmpStr = '';
		echo '<li> <strong class="goods_bt">'.$v['pTitle'].'</strong>  <span>￥'.$v['tPrice'].'</span><strong class="goods_jg">X '.$v['eNum'].'</strong></li>';
	}
}
?>
</ul>
<ul class="goods_zj">
<li > <strong class="goods_bt">合计</strong>  <span>￥<?php echo $orderRes['oMoney'];?></span></li>
<li> <strong class="goods_bt">优惠</strong>  <span>￥<?php echo $orderRes['dMoney'];?></span></li>
<li> <strong class="goods_bt">实收</strong>  <span>￥<?php echo $orderRes['nMoney'];?></span></li>
</ul>
<?php 
if(empty($orderRes['payCode'])){
?>
<p>货到付款</p>
<div class="goods_yh"><span>优惠说明</span></div>
<?php 
}else{
echo '<p>在线支付</p>
<div class="goods_yh"><span>优惠说明</span></div>';	
}
?>
</div>
<?php 
if($orderRes['oStatus']=='3'){
?>
<div class="car">
		<p>
			<span id="orderEndTotalMoney">总计￥<?php echo $orderRes['nMoney'];?></span> <strong id="orderEndMarketing"></strong>
		</p>
		<a href="javascript:void(0)" id="replayOrder">重新下单</a>
</div>
<?php 
}
?>

<div class="popup">
  <h4>优惠说明<br><br>
使用在线支付，即可享受优惠。<br>
仅限每月首单。</h4>
	<p id="discountNoteHtml"></p>
  <a href="javascript:void(0)" class="sign_aniu">确定</a> 
</div>

<script  type="text/javascript">
var _detailId = getUrlParam('i');
$(document).ready(function(){
	
	$(".goods_yh span").click(function(){
		$(".box").show();
         $(".popup").show(); 		
		
		});
$(".sign_aniu").click(function(){
		$(".box").hide();
         $(".popup").hide(); 		
		
		})	
	
	});
var _s_u_b = 0;
$('#replayOrder').click(function(){
	if(_s_u_b==0){
		_s_u_b++;
		var _params = 'action=ShopOrder&run=replayCreateOrder&i='+_detailId;
		ComClass.post(_params,callBack);
	}
});
function callBack(data){
	_s_u_b--;
	window.location.href="shop.php?tpl=v1.shop.goods.list&i=1";
}
//加载优惠活动
var _shopMarketingAct = SessionUtils.getParam('shopMarketingAct');
if(_shopMarketingAct==null){
	var _params = 'action=ShopMarketing&run=getShopMarketing';
	ComClass.post(_params,marketingLoadCallBack);	
}else{
	marketingLoadCallBack(_shopMarketingAct);
}
function marketingLoadCallBack(data){
	var _d = eval('('+data+')');
	SessionUtils.setParam('shopMarketingAct',data);	
	if(_d.code=='1'){
		var _html = '';
		var i = 1;
		for(o in _d.msg){
			if(_d.msg[o].wType=='1'){
				_html += i+'、满'+parseInt(_d.msg[o].money)+'减'+parseInt(_d.msg[o].nMoney)+'元<br>';
			}else if(_d.msg[o].wType=='2'){
				_html += i+'、满'+parseInt(_d.msg[o].money)+'赠商品<br>'
			}
			i++;
		}
		$('#discountNoteHtml').html(_html);
	}else{
		
	}
}
</script>
<div class="box " style=" z-index:25">
</div>