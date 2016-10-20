<?php 
$uRes = Run::c();
$obj = C('InsPrice');
$qxRes = $obj->getInsPriceStatus();
?>
<img src="<?php echo IMG_PATH;?>toubao.jpg" width="100%" />

<section class="insured">
<h2><span>投保人信息</span> <strong id="btn_add">+加人</strong></h2>
<form action="?tpl=v1.ins.pay" method="post" name="myform">
<div class="insur_nei">
	<table class="tbg tbg1" cellpadding="0" cellspacing="0">
		<tr>
			<td>姓名</td>
			<td><input type="text" name="xm[]" placeholder="请输入姓名"></td>
		</tr>
		<tr>
			<td>身份证</td>
			<td><input type="text" name="idcard[]" placeholder="请输入身份证号码" onblur="checkIdentity($(this))"></td>
		</tr>
	</table>
	<p class="insured_tishi"></p>
</div>
</form>

<h3>期限</h3>
<ul class="insur_qx">
<?php 
foreach ($qxRes as $qk=>$qv){
	if($qk=='0'){
		$_tmpStr = 'active_in';
	}else{
		$_tmpStr = '';
	}
	echo "<li><span class='{$_tmpStr}' _span='{$qv['pSpan']}' _dis='{$qv['pDis']}' _p='{$qv['pPrice']}' _np='{$qv['pNPrice']}' >{$qv['pSpan']}个月</span></li>";
}
?>
</ul>

<p class="insu_bf">保费：<strong id="price">￥00</strong></p>

<div class="Buy_btn4 submit_order clear" id="btn_s"><a href="javascript:void(0);">在线支付</a></div>

</section>
<script src="<?php echo JS_PATH;?>ins.js"></script>