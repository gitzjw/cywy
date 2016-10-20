<?php 
Run::c('v1.mjd.order');
$parObj = new ParamsController();

$_u = $parObj->getSessionParams('userDetail');

$wObj = new WebTypeController();
$wCity = $wObj->getInfiniteHtml('4','20');
$wType = $wObj->getInfiniteHtml('4','15');

$mjdFwfsName = $parObj->getSessionParams('mjdFwfsName');
$mjdFwfsId =  $parObj->getSessionParams('mjdFwfsId');
$mjdCityName = $parObj->getSessionParams('mjdCityName');
$mjdCityId = $parObj->getSessionParams('mjdCityId');
$mjdCityName = $mjdCityName?$mjdCityName:'北京';
$mjdCityId = $mjdCityId?$mjdCityId:'21';

if($mjdCityName=='北京'){
	//$_tmpCitySpanStr = '<strong>服务覆盖北京五环内</strong>';
}else if($mjdCityName=='上海'){
	//$_tmpCitySpanStr = '<strong>服务覆盖上海外环内</strong>';
}else if($mjdCityName=='深圳'){
	//$_tmpCitySpanStr = '<strong>服务覆盖深圳全市境内</strong>';
}
$_tmpCitySpanStr = '';

$parObj->localSetParams('mjdCityName', $mjdCityName);
$parObj->localSetParams('mjdCityId', $mjdCityId);

$rpObj = new RepairPriceController($mjdCityId);
$rpRes = $rpObj->getRepairPriceCity($mjdCityId);
?>
<section class="mgs_order">
	<p class="order_fwfs order_fwfs1" id="cityP">
		<label>选择城市：</label>
		<span id="cityName"><?php echo $mjdCityName?$mjdCityName:'请选择所在城市';?> <img src="<?php echo IMG_PATH;?>you1.png" width="10"><?php echo $_tmpCitySpanStr;?></span>		
	</p>
	<p class="order_fwfs" id="fwfsP">
		<label>服务方式：</label>
		<span id="fwfsName"><?php echo $mjdFwfsName?$mjdFwfsName:'请选择服务方式';?> <img src="<?php echo IMG_PATH;?>you1.png" width="10"></span>
	</p>
	<ul class="order_sl">
		<li>
			<label>数量：</label>
			<span>磨剪刀 <input class="inputdata" onblur="checkPrice()" min="0" value="0" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')"  _v="17" _o="<?php echo isset($rpRes['17']['oPrice'])?$rpRes['17']['oPrice']:'0';?>" _d="<?php echo isset($rpRes['17']['dPrice'])?$rpRes['17']['dPrice']:'0';?>" _n="<?php echo isset($rpRes['17']['nPrice'])?$rpRes['17']['nPrice']:'0';?>" type="number" placeholder="数量">&nbsp;&nbsp;x&nbsp;<?php echo isset($rpRes['17']['oPrice'])?intval($rpRes['17']['oPrice']):'0';?>元/个</span>
		</li>
		<li>
			<span>磨刀头 <input class="inputdata" onblur="checkPrice()" min="0"  value="0" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" _v="16"  _o="<?php echo isset($rpRes['16']['oPrice'])?$rpRes['16']['oPrice']:'0';?>" _d="<?php echo isset($rpRes['16']['dPrice'])?$rpRes['16']['dPrice']:'0';?>" _n="<?php echo isset($rpRes['16']['nPrice'])?$rpRes['16']['nPrice']:'0';?>"  type="number" placeholder="数量">&nbsp;&nbsp;x&nbsp;<?php echo isset($rpRes['16']['oPrice'])?intval($rpRes['16']['oPrice']):'0';?>元/个</span>
		</li>
	</ul>
	<div class="or_qie" style="display:none;" id="yjfw">
		<p class="order_jy"><label>请寄邮到：</label> <span id="mAddress">北京市东城区珠市口东大街甲16号世纪天鼎购物广场西外A01（爱宠屋），赵师傅（收）</span></p>
		<p class="order_jy"><label>回寄地址&电话：</label><textarea onblur="checkAds()" id="bAddress" placeholder="请输出，赵师傅磨完后，给你回寄的地址"><?php echo $parObj->getSessionParams('badsVal');?></textarea><textarea type="text" placeholder="" style="height:25px;"><?php echo $_u['telNumber'];?></textarea></p>
	</div>
	<div class="or_qie" style="display:none;" id="smfw">
		<p class="order_jy"><label>上门地址：</label><textarea onblur="checkAds()"  id="cAddress" placeholder="请输入您的地址，师傅会在3天内上门为您服务"><?php echo $parObj->getSessionParams('cadsVal');?></textarea></p>
	</div>
	<div class="order_jg">
		价格：
		<div class="or_je" id="nPrice">
			<div class="or_je1">￥</div>0
		</div>
		<div class="or_je2" id="oPrice">￥0</div>
	</div>
</section>

<div class="Buy_btn4 submit_order"><a href="javascript:void(0)" id="btn_s">支付</a><div class="zfts">*赵师傅收到剪刀后，会先进行检查，如果刀头零部件（导向条、固定板等）有故障，会先与您联系确认是否需要更换。<br />*磨完后，1-2天给您回寄（顺丰速递）。快递费往返请自理。
</div></div>

<div class="tc_fwxm" id="boxPrev">
	<ul id="boxContentUl">
		<li class="tc_bt" _vid="" _vname="">选择服务方式</li>
		<?php 
		foreach ($wType as $k=>$v){			
			if($v['id']=='18'){
				continue;
			}
		?>
		<li _vid="<?php echo $v['id'];?>" _vname="<?php echo $v['sName'];?>"><a href="javascript:void(0)"><?php echo $v['sName'];?></a></li>
		<?php 
		}
		?>
	</ul>
	<a href="javascript:void(0)" id="quitBox">取消</a>
</div>

<div class="tc_fwxm" id="boxCityPrev">
	<ul id="boxContentCityUl">
		<li class="tc_bt" _vid="" _vname="">选择所在城市</li>
		<?php 
		foreach ($wCity as $k=>$v){			
		?>
		<li _vid="<?php echo $v['id'];?>" _vname="<?php echo $v['sName'];?>"><a href="javascript:void(0)"><?php echo $v['sName'];?></a></li>
		<?php 
		}
		?>
	</ul>
	<a href="javascript:void(0)" id="quitCityBox">取消</a>
</div>

<div class="box" id="box"></div>
<script src="<?php echo JS_PATH;?>mjd.order.js"></script>
<script>
defaultShowAds('<?php echo $mjdFwfsId?>');
</script>