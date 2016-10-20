<section class="margin lxdh">
<p class="tishi">专员申请</p>  
  <div class="border_1">
    <input   placeholder="请输入姓名" id="sName"  type="text"/>
  </div>
  <div class="border_1">
    <input   placeholder="请输入电话" id="sTel"  type="text"/>
  </div>
  <div class="border_1">
    <input   placeholder="请输入邮箱" id="sEmail"  type="text"/>
  </div>
   <select name="wType" id="wType" style=" width:100%;height:40px;border:#ccc solid 1px; color:#666"><option value="1">BD专员</option><option value="2">采购专员</option><option value="3">配送专员</option><option value="4">财务专员</option></select>
 
   <select name="city" id="city"  style=" width:100%;margin-top:20px;height:40px;border:#ccc solid 1px; color:#666">
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
	_valStr += '&wType='+$('#wType').val();
	_valStr += '&city='+$('#city').val();
	_valStr += '&';
	return _valStr;
}
$('#btn_s').click(
		function() {
			var _val = getFormValue();
			_val += 'action=ShopSpeUser&run=addShopSpeUser';
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