<?php
$obj = new CakeShopController();
$res = $obj->getCakeShopUid(1);

if(!empty($res)){
	if($res['status']=='1'){
		Run::show_msg('','1','?tpl=v1.cake.shop.success');
	}elseif($res['status']=='2'){
		Run::show_msg('','1','?tpl=v1.cake.main');
	}
}
?>
<section class="margin lxdh">
<p class="tishi">销售蛋糕，需要先申请成为合作商家</p>  
  <div class="border_1">
    <input   placeholder="请输入宠物店名" id="shopName"  type="text"/>
  </div>
  <div class="border_1">
    <input   placeholder="请输入宠物店联系人" id="shopMainName"  type="text"/>
  </div>
  <div class="border_1">
    <input   placeholder="请输入宠物店地址" id="shopAddress"  type="text"/>
  </div>
  <div class="border_2">
    <input   placeholder="请输入联系电话" id="shopTel"  type="number" maxlength="11" />
  </div>
  <select name="city" id="city"  style=" width:100%;height:40px;border:#ccc solid 1px; color:#666">
  <?php 
  $cityRes = Run::getCityCode('','');
  foreach ($cityRes as $ck=>$cv){
  	echo "<option value='{$ck}'>{$cv}</option>";
  }
  ?>
  </select>
</section>
<div class="Buy_btn4 submit_order   "> <a id="btn_s" _b="0" href="javascript:void(0);">提交申请</a> </div>
<script>
_s_u_b = 0;
function getFormValue() {
	var _valStr = '';
	$('input').each(function() {
		_valStr += $(this).attr('id')+'='+$(this).val();
		_valStr += '& ';
	});
	_valStr += '&city='+$('#city').val();
	_valStr += '&';
	return _valStr;
}
$('#btn_s').click(
		function() {
			var _val = getFormValue();
			_val += 'action=CakeShop&run=applyCakeShop&modNum';
			if (_s_u_b == 0) {
				++_s_u_b;
				ComClass.post(_val, callbackData);
			}
		});
function callbackData(data) {
	var _d = eval('(' + data + ')');
	if (_d.code == '1') {
		_e = _d.msg;
		alert(_e);
		window.location.reload();
	} else {
		_s_u_b = 0;
		alert(_d.msg);
	}
}
</script>