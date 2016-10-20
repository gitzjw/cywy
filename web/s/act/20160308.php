<?php
include_once '../../public/config.inc.php';
include_once '../../public/config.route.php';
die ( '<html>
		    <head>
		    	<title>抱歉，活动已经结束了</title>
		        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		        <style>
					body{background:#e1e0de;line-height: 1.6;
					font-family: "Helvetica Neue",Helvetica,"Microsoft YaHei",Arial,Tahoma,sans-serif;text-align: center}
					img{margin-top:40px;}
					p{font-weight: 400;color: #000000;}							
				</style>
		    </head>
			<body>
				<img src="http://img.momopet.cn:4869/4a06f368048c265f1f1c18b99d59d237?f=png" />
				<p>抱歉，活动已经结束了</p>
			</body>
		</html>' );
exit ();
Run::checkBrowser();

$obj = new CakeShopController();
$_shopRes = $obj->getCakeShopUid();
if(empty($_shopRes)){
	Run::show_msg('','1','/shop.php?tpl=v1.shop.shop');
}elseif(empty($_shopRes['shopInvCode'])){
	Run::show_msg('','1','/shop.php?tpl=v1.shop.shop');
}

$shopProObj = new ShopProController();
$shopProRes = $shopProObj->getShopProAct();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>萌工社</title>
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script src="/public/js/jquery-1.8.3.min.js"></script>  
</head>

<body>
<img src="images/bd.jpg" width="100%">
<div class="xqnr">
<p class="btnr">以下药品，最少起订量10盒，最多限购40盒封顶！ 每个城市仅限前50个名额可享活动价，售完即恢复原价！下单成功后可在"我的订单"中查看订单详情。如有疑问请咨询：4007-007-580</p>
<div class="xq_1">
<h2>&middot; 活动时间<span>(3月9日-3月31日)</span></h2>
<table cellpadding="0" cellspacing="0" border="0">
<tr><th>药品名称</th><th>原价</th><th>活动价</th><th>购买数量</th></tr>
<?php 
foreach ($shopProRes as $k=>$v){
?>
<tr>
	<td width="120"><?php echo $v['title'],'('.$v['sUnit'].')';?></td>
	<td width="50"><?php echo intval($v['oPrice']);?>元</td>
	<td class="color1" width="50"><?php echo intval($v['nPrice']);?>元</td>
	<td>
		<p class="jiajian" _list="<?php echo $v['id'];?>" _title="<?php echo $v['title'];?>" _o="<?php echo $v['oPrice'];?>" _n="<?php echo $v['nPrice'];?>" _w="<?php echo $v['wType'];?>">
			<span class="minus" onclick="jian($(this))" style=""></span> <span class="shuzi">0</span><span class="add" onclick="add($(this))"></span>
		</p>
	</td>
</tr>
<?php 
}
?>
<tr><td colspan="4"><p class="zongji"><span>总计：</span> <strong style="text-decoration:line-through;font-weight:normal" id="oppp">原价：0</strong> <strong id="nppp">活动价：0</strong></p></td></tr>
</table>
<section class="margin lxdh" >
 <div class="border_1 margin20" >
    <input   placeholder="收货人地址"  value="<?php echo $_shopRes['shopAddress'];?>" type="text" class="zhuce_2"  readonly="readonly"/>
  </div>

  <div class="border_1">
    <input   placeholder="收货人姓名"   value="<?php echo $_shopRes['shopMainName'];?>" type="text" class="zhuce_3"  readonly="readonly"/>
  </div>
  <div class="border_1">
    <input   placeholder="联系电话（请填写手机号）"  value="<?php echo $_shopRes['shopTel'];?>"  type="text" class="zhuce_4"  readonly="readonly"/>
  </div>
</section>

</div>
<div class="Buy_btn4 submit_order"> <a href="javascript:void(0)" id="pay">支付</a> </div>
<script>
var _totalNum = 0;
var _totalPrice = 0;
var _totalOPrice = 0;
var _tmpCarStr = '';
						var ComClass = {
							setParams : function(params) {
								$.post("/c/run.php", params, function(data, textStatus) {
									 console.log(data);
								});
							},
						    post: function(params, callback){
						        $.post("/c/run.php", params, function(data, textStatus){
						            callback(data);
						        });
						    },
						    
						    href: function(tpl){
						        window.location.href = this.webSite + tpl;
						    }
						    
						};

						var _carArray  = new Array();
						var jian = function(obj){
							var proNum = obj.next().html();

							if(proNum=='0'){
								return false;
							}
							
							var _id = obj.parent().attr('_list');
							var _oprice = parseFloat(obj.parent().attr('_o'));
							var _price = parseFloat(obj.parent().attr('_n'));
							var _title = obj.parent().attr('_title');							
							var _wtype_tmp = obj.parent().attr('_w');							
							
							if(proNum==1){
								proNum = parseInt(proNum)-1;
								_totalNum-=1;
								_totalPrice-=_price;
								_totalOPrice-=_oprice;
								
								_carArray[_id] = new Array();
								obj.next().html(0);
								opCar();
								return false;
							}else{
								proNum = parseInt(proNum)-1;								
								_totalNum-=1;
								_totalPrice-=_price;
								_totalOPrice-=_oprice;
								var _proPrice = parseFloat(_price*proNum);
								var _proOPrice = parseFloat(_oprice*proNum);
								_carArray[_id] = new Array(_id,_price,_title,proNum,_proPrice,_wtype_tmp,_oprice,_proOPrice);
								obj.next().html(proNum);
								opCar();
							}							
						};
						var add = function(obj){
							var proNum = obj.prev().html();

							if(_totalNum>=40){
								alert('最多可选择40件');return false;
							}
							

							proNum = parseInt(proNum)+1;

							var _id = obj.parent().attr('_list');
							var _oprice = parseFloat(obj.parent().attr('_o'));
							var _price = parseFloat(obj.parent().attr('_n'));
							var _title = obj.parent().attr('_title');
							var _proPrice = parseFloat(_price*proNum);
							var _proOPrice = parseFloat(_oprice*proNum);
							var _wtype_tmp = obj.parent().attr('_w');
							
							_carArray[_id] = new Array(_id,_price,_title,proNum,_proPrice,_wtype_tmp,_oprice,_proOPrice);
							obj.prev().html(proNum);

							_totalNum+=1;
							_totalPrice+=_price;
							_totalOPrice+=_oprice;
							
							opCar();						
						};

						var opCar = function(){
							if(_totalNum>0){
								$('#oppp').html('原价：'+_totalOPrice);
								$('#nppp').html('活动价：'+_totalPrice);
							}else{
								$('#oppp').html('原价：0');
								$('#nppp').html('活动价：0');
							}
							var _tmpCarDStr = '';
							for(o in _carArray){	
								if(typeof(_carArray[o][0])=='undefined'){
									_tmpCarDStr+='"'+o+'":[""],';
								}else{
									_tmpCarDStr+='"'+_carArray[o][0]+'":["'+_carArray[o][0]+'","'+_carArray[o][1]+'","'+_carArray[o][2]+'","'+_carArray[o][3]+'","'+_carArray[o][4]+'","'+_carArray[o][5]+'","'+_carArray[o][6]+'"],';									
								}		
							}							
							_tmpCarStr = '{"code":"1","msg":{"car":{'+_tmpCarDStr+'"":[]},"totalNum":"'+_totalNum+'","totalPrice":"'+_totalPrice+'","totalOPrice":"'+_totalOPrice+'"}}';				
						}
						
						var _oid='';
						var _s_u_b=0;
						$('#pay').click(
								function() {
									if(_totalNum<10){
										alert('必须大于10盒，才能下单')
										return false;
									}
									if(_oid==''){
										var _params = 'action=ShopPro&run=setShopCarData&car='+_tmpCarStr;
										ComClass.setParams(_params);
										var _val = 'action=ShopOrder&run=cOrderActPay';
									}else{
										var _val = 'action=ShopOrder&run=cOrderActPay&_oid='+_oid;
									}
									if (_s_u_b == 0) {
										++_s_u_b;										
										ComClass.post(_val, callbackData);
									}
								});
						function callbackData(data) {
							var _d = eval('(' + data + ')');
							if (_d.code == '1') {
								_e = _d.msg;
								_oid = _e.oid;
								onBridgeReady();
							} else {
								_s_u_b = 0;
								alert(_d.msg);
							}
						}
						
						function onBridgeReady() {
							WeixinJSBridge.invoke('getBrandWCPayRequest', {
								"appId" : _e.appid, // 公众号名称，由商户传入
								"timeStamp" : _e.timestamp+"", // 时间戳，自1970年以来的秒数
								"nonceStr" : _e.newRndstr, // 随机串
								"package" : "prepay_id=" + _e.prepay_id,
								"signType" : "MD5", // 微信签名方式:
								"paySign" : _e.newSign
							// 微信签名
							}, function(res) {
								// 使用以下方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回 ok，但并不保证它绝对可靠。
								if (res.err_msg == "get_brand_wcpay_request:ok") {
									alert('支付成功');
									WeixinJSBridge.invoke('closeWindow', {}, function(res) {
									});
								} else {
									_s_u_b = 0;
									alert('支付失败，请重新进行操作');
									// WeixinJSBridge.invoke('closeWindow', {}, function(res){});
								}
							});
						}						
					</script>
</body>
</html>