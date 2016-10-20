<?php 
$obj = new ShopSpeUserController();
$_tmpRes = $obj->getShopSpeUserOpenId();
if(empty($_tmpRes)){
	die('非BD商务管理人员');
}
if(empty($_tmpRes['shopCode'])){
  	die('非BD商务管理人员.');
}
$sObj = new CakeShopController();
$sohObj = new ShopOrderController();
?>
<div class="se_nav">
  <p><span class="active" id="wdkh">我的客户</span><span id="xsyj">销售业绩</span></p>
</div>
<div class="service_z margin_t">
  <div class="cwd_list" id="qd_kh_list">
  <?php 
  $_tmpRes = $obj->getShopSpeId($_tmpRes['shopCode']); 
  
  foreach ($_tmpRes as $k=>$v){
  	$_tmpShopOrderHis = $obj->getShopOrderHistoryUid($v['uId']);  	
  ?>
    <dl _u="<?php echo $v['uId'];?>">
      <dt class="clc"><?php echo $v['shopName'];?></dt>
      <dd class="clc">店长：<?php echo $v['shopMainName'];?></dd>
      <dd class="clc">电话：<?php echo $v['shopTel'];?></dd>
      <dd class="clc">地址：<?php echo $v['shopAddress'];?> </dd>      
      <?php 
      if($_tmpShopOrderHis){
      ?>
      <dd class="clc">最近订单：<?php echo Run::getFormatDate($_tmpShopOrderHis['createTime'],'m-d H:i'),' ',$sohObj->getStatusDesc($_tmpShopOrderHis['oStatus']);?></dd>
      <?php 
      }
      if($v['status']!='2'){
      	echo '<dd class="se_caoz"><span class="editor" sid="'.$v['id'].'" slxr="'.$v['shopMainName'].'" sdm="'.$v['shopName'].'" sdh="'.$v['shopTel'].'" sdz="'.$v['shopAddress'].'" scs="'.$v['city'].'" syqm="'.$v['shopInvCode'].'">编辑</span><span sid="'.$v['id'].'"  class="pass1">通过</span></dd>';
      }
      ?>      
    </dl>
    <div class="background1 height2"></div>
  <?php 
  }
  ?>
<!--    <a href="?tpl=v1.bd.manager.add" class="cwd_xin">新增</a> -->

  </div>    
  
  <div class="cwd_list" id="xs_yj_list" style="display:none">
  
  </div>
  
  <div class="popup_l">
			<section class="margin lxdh">
				<div class="border_1">
				    <input   placeholder="请输入宠物店名" id="shopName"  type="text"/>
				  </div>
				  <div class="border_1">
				    <input   placeholder="请输入宠物店联系人" id="shopMainName"  type="text"/>
				  </div>
				  <div class="border_1">
				    <input   placeholder="请输入宠物店地址" id="shopAddress"  type="text"/>
				  </div>
				  <div class="border_1">
				    <input   placeholder="请输入联系电话" id="shopTel"  type="number" maxlength="11" />
				  </div>
				  <div class="border_1 margin20">
					<select class="zhuce_6" id="city" name="city">
						<?php 
						  $cityRes = Run::getCityCode('','');
						  foreach ($cityRes as $ck=>$cv){
						  	echo "<option value='{$ck}'>{$cv}</option>";
						  }
						?>
					</select>
				</div>				
				<div class="border_1">
					<input placeholder="邀请码" type="text" id="shopInvCode" class="zhuce_5" readonly="readonly" />
				</div>
			</section>
			<div class="Buy_btn4 submit_order" style="padding-bottom:3%">
				<a href="javascript:void(0)" id="btn_s">提交</a>
			</div>
	</div>
	
	<div id="loadMsgAbc" style="position:fixed;top:40%;left:5%;width:80%;background:#fff; z-index:1000; -webkit-border-radius: 5px;-moz-border-radius: 5px; border-radius: 5px; padding: 10px 5% 10px 5% ; display:none;">
		加载中，请稍后...
	</div>
</div>
<div class="box " style=" z-index:25">
		</div>
<script src="<?php echo JS_PATH;?>bd.manager.admin.js"></script>

<script type="text/javascript">
		var _id = 0;
		$(".editor").click(function() {
			$(".box").show();
			$(".popup_l").show();

			$('#shopName').val($(this).attr('sdm'));
			$('#shopMainName').val($(this).attr('slxr'));
			$('#shopAddress').val($(this).attr('sdz'));
			$('#shopTel').val($(this).attr('sdh'));
			$('#shopInvCode').val($(this).attr('syqm'));
			$('#city').find('option').removeAttr("selected");
			$('#city').find('option[value="'+$(this).attr('scs')+'"]').attr("selected","selected");
			$('#city').val($(this).attr('scs'));
			_id = $(this).attr('sid');
		});
		$(".box").click(function() {
			$(".box").hide();
			$(".popup_l").hide();
			$('#loadMsgAbc').hide();
		});
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
					_val += 'action=CakeShop&run=saveCakeShop&id='+_id;
					if (_s_u_b == 0) {
						++_s_u_b;
						ComClass.post(_val, callbackData);
					}
				});
		function callbackData(data) {
			alert(data);
			window.location.reload();
		}

		$(".pass1").click(function() {
			var _vid = $(this).attr('sid');
			var _va = 'action=CakeShop&run=updateStatus&_id='+_vid+'&_s=2';
			ComClass.post(_va, callbackData);
		});
		
</script>