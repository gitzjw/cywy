<?php
$obj = new ParamsController();
$user = $obj->getSessionParams ( 'userDetail' );
if (!empty ( $user )) {
	Run::show_msg ( '', 1, APP_WEBSITE . '?tpl=v1.person.d' );
}
$oid = $obj->getSessionParams('openid');
//$obj->unsetAll();
$obj->localSetParams ( 'openid', $oid );
$_brekHref = Run::req('b');
$_brekHref = empty($_brekHref)?'v1.person.d':$_brekHref;
?>
<section class="margin lxdh">
<p class="tishi">使用宠业无忧相关服务，清先进行登录。</p>
  <div class="border_1">
    <input   placeholder="请输入身份证号码(用于查看保单)" id="idcard"  type="text"/>
  </div>
  <div class="border_2">
    <input   placeholder="请输入手机号码" id="telnumInput"  type="number" maxlength="11" />
  </div>
  <div class="Buy_btn5  " style="width:40%;padding:0;float:right;"> <a href="javascript:send();" id="checkcodeA" style="padding: 0 10px;font-size:16px;width:80%;height:40px;line-height:41px;">获取验证码</a> </div>
  <div class="clear"></div>
  <div class="border_1">
    <input   placeholder="请输入验证码" maxlength="6" id="checkcodeInput" type="number"/>
  </div>
</section>
<div class="Buy_btn5 submit_order   "> <a id="s" _b="0" href="javascript:void(0);">登录</a> </div>
<script type="text/javascript">
var openid="<?php echo $oid;?>";
var brekHref="<?php echo '?tpl='.$_brekHref;?>";
</script>
<script src="<?php echo JS_PATH;?>reg.js"></script>