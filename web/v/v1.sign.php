<?php 
$sObj = C('SignMain');
$srObj = C('SignMainRecord');
$swpObj = C('SignWinPro');
$signUserDetail = $sObj->findSignMainUid();
$signUserIs = $srObj->checkUserSignSingle($signUserDetail['uId']);
$swpRes = $swpObj->getSignWinProDate();
?>
<div class="sign">
<?php 
if(!$signUserIs){
?>
<a href="javascript:void(0)" id="sign_button" class="sign_button">签到</a>
<?php
}else{
?>
<a href="javascript:void(0)" class="sign_button">已签到</a>
<?php 	
} 
?>
<p>您已连续签到<?php echo $signUserDetail['mContNum'];?>天</p>
<p>本月累计签到<?php echo $signUserDetail['mTotalNum'];?>天</p>

<span class="sign_gz">签到攻略</span>

</div>

<table cellpadding="0" cellspacing="0" border="0" class="sign_tb">
	<?php 
		echo $sObj->displayCalendar();
	?>
</table>

<div class="sign_jl">
	<h2>本月签到活动奖励</h2>
	<ul class="jf_dhlb ">
	<?php 
	foreach ($swpRes as $swpk=>$swpv){
	?>
		<li>
			<a href="javascript:void(0);" _i="<?php echo $swpv['id'];?>">
				<dl>
					<dt><img src="<?php echo $swpv['imgPath'];?>"></dt>
					<dd><?php echo $swpv['title'];?></dd>
					<dd class="jf_xt"><?php echo $swpv['subTitle'];?></dd>
					<dd id="dd_c_<?php echo $swpv['id'];?>" style="display:none"><p><?php echo $swpv['content'];?></p></dd>					
				</dl>
			</a>
		</li>
	<?php 
	}
	?>
	</ul>
</div>

<div class="popup">
	<div id="content_html">
	<h4>签到攻略</h4>
	<p>1. 每月连续签到7天、15天、30天领取相应的签到奖励</p>
	<p>2.对不正当手段（包括但不限于作弊、扰乱系统、实施网络攻击等）参与活动的用户，萌工社有权禁止其参加活动，取消其获奖资格（如奖励已发放，萌工社有权追回）</p>
	<p>3. 此活动最终解释权归萌工社所有</p>
	</div>
	<a href="javascript:void(0)" class="sign_aniu">确定</a>
</div>
<div class="box"></div>
<script type="text/javascript" src="<?php echo JS_PATH;?>sign.js"></script>