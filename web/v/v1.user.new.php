<?php
$usersObj = new UsersController();
$_res = $usersObj->getUserDetail();
if(!empty($_res)){
	$obj = new CakeShopController();
	$res = $obj->getCakeShopUid(1);
	if(empty($res)){
		//Run::show_msg('','1','index.php?tpl=v1.person.d');
	}
	if($res['status']=='1'){
		Run::show_msg('','1','index.php?tpl=v1.cake.shop.success');
	}elseif($res['status']=='2'){
		if($res['shopInvCode']!=''){
			Run::show_msg('','1','shop.php?tpl=v1.shop.index');
		}
	}
}
?>
<img src="<?php echo IMG_PATH;?>ppsj.jpg" width="100%;">
<section class="margin lxdh" style="margin-top:0;">
	<div class="dh_ts">
	① 原萌工社已注册商家<br />
	请输入，您之前在【萌工社】平台上，注册时填写的手机号码。<br />
	系统将自动检测，为您进行原有账号关联，即可进入【宠业无忧】新平台正常使用下单。<br /><br />
	② 新合作商家<br />
	填写手机号，进入注册页面。<br />
	在注册页面请将信息填写完整，邀请码由商务经理为您提供。注册完成即可进入【宠业无忧】平台正常使用下单。<br />
	<br />
	操作过程中，遇到任何问题，请咨询商务经理。
	</div>

	<div class="border_1"><input placeholder="请输入手机号码" id="tel" type="number" class="zhuce_4" /></div>
</section>
<div class="Buy_btn4 submit_order"><a href="javascript:void(0);" id="btnSub">提交</a></div>

<script>
var __sub = 0;
$('#btnSub').click(function(){
	var _tel = $('#tel').val();
	if($.trim(_tel)==''){
		$('#tel').focus();
		return false;
	}	
	if(__sub===0){		
		var _params = 'action=Users&run=checkNewOpenId&_tel='+$('#tel').val();
		ComClass.post(_params,postCallBack);	
	}
});
var postCallBack = function(data){
	var _d = eval('('+data+')');
	if(_d.code=='1'){
		alert(_d.msg);
		window.location.reload();
	}else if(_d.code=='102'){
		alert(_d.msg);
	}else if(_d.code=='103'){
		window.location.href = "shop.php?tpl=v1.shop.shop";
		//log(_d.msg);
	}
}
</script>