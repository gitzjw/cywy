<img src="<?php echo IMG_PATH;?>hzhbbanner.jpg"  width="100%;">
<section class="margin lxdh" style="margin-top:0;">
<div class="dh_ts">加入萌工社生态平台，成为高级合作伙伴，即可享受由萌工社提供的商品供应链服务，这里有更低的采购价、更好的服务。</div>
<?php 
$_sss = '1';
if($_sss=='1'){
?>
	<div class="border_1 margin20">
	   <select name="city" id="city"   class="zhuce_6">
	  <?php 
	  $cityRes = Run::getCityCode('','');
	  foreach ($cityRes as $ck=>$cv){
	  	echo "<option value='{$ck}'>{$cv}</option>";
	  }
	  ?>
	  </select>
  </div>
  <div class="border_1 margin20">
    <input   placeholder="请输入宠物店名" id="shopName"  type="text" class="zhuce_1"/>
  </div>
  <div class="border_1 margin20">
    <input   placeholder="宠物店地址（请认真填写，此处为采购配送地址）" id="shopAddress"  type="text" class="zhuce_2"/>
  </div>
  <div class="border_1">
    <input   placeholder="请输入宠物店联系人" id="shopMainName"  type="text" class="zhuce_3"/>
  </div>  
  <div class="border_1">
    <input  placeholder="联系电话（请填写手机号）" id="shopTel"  type="number" maxlength="11"  class="zhuce_4"/>
  </div>
<?php 
}
?>
  <div class="border_1">
    <input   placeholder="邀请码"  id="shopInviteCode"  type="text" class="zhuce_5"/>   
  </div> 
  <div>*现阶段采用邀请注册制，请联系商务经理索取邀请码。</div>
</section>
<div class="Buy_btn4 submit_order   "> <a id="btn_abcabc" _b="0" href="javascript:void(0);">注册</a> </div>
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
			_val += 'action=CakeShop&run=applyShopShop&modNum';
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
		window.location.href="shop.php?tpl=";
	} else {
		_s_u_b = 0;
		alert(_d.msg);
	}
}
</script>