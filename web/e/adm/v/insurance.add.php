<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	$wObj = C('WebType');
	$wRes = $wObj->getInfiniteHtml('4','1');
	$iObj = C('InsMember');
	if($_i){
		$iRes = $iObj->getInsMemberAll();
	}else{
		$iRes = $iObj->getInsMemberDisAll();
	}	
	$seObj = C('SerMember');
	$seRes = $seObj->getSerMemberAll();
	$tObj = C('Ins');
	if($_i){	    
	    $res = $tObj->getInsId($_i);
	}
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_WEBSITE,'public/js/';?>My97DatePicker/WdatePicker.js"></script>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑保单</h3>
			<div class="submit_a_link">
				<a href="javascript:history.go(-1);" class="alt_btn">返回</a>
			</div>			
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveIns">
		  <input type="hidden" name="action" value="Ins">
    		<div class="tab_container">
    			<div id="tab1" class="tab_content" style="display: block;">
    				<div class="module_content">    				
    				<?php 
    				if($_i){
    					checkAdmin('1');
    					$_btnStr='保存';
    				?>
    				        <fieldset>
    							<label>ID：<?php echo $_i;?></label>										
    						</fieldset>
    				<?php 
    				}
    				?>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>保险单号</label>
    							<input type="text" name="iInsId" id="iInsId"  value="000006252992088" readonly>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>分类</label>
    							<?php 
    								echo $wObj->getSelectHtml($wRes);
    							?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>服务人员1号</label>
    							<select name="smIdOne">  
    								<?php 
    									foreach ($seRes as $sk=>$sv){
    								?>
    								<option value="<?php echo $sk;?>" <?php isArrSelEcho($res, 'smIdOne', $sk,'selected');?>><?php echo $sv['sName'];?></option>
    								<?php 
    									}
    								?>
    							</select>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>服务人员2号</label>
    							<select name="smIdTwo">    								
    								<?php 
    									foreach ($seRes as $sk=>$sv){
    								?>
    								<option value="<?php echo $sk;?>" <?php isArrSelEcho($res, 'smIdTwo', $sk,'selected');?>><?php echo $sv['sName'];?></option>
    								<?php 
    									}
    								?>
    							</select>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>开始时间</label>
    							<input type="text" name="iStart" id="d4311" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{\'2050-10-01\'}'})"  value="<?php isArrEcho($res, 'iStart');?>" >
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>持续时间</label>
    							<select name="iSpan">
    								<option value="3"  <?php isArrSelEcho($res, 'iSpan', '3','selected');?>>三个月</option>
    								<option value="6"  <?php isArrSelEcho($res, 'iSpan', '6','selected');?>>六个月</option>
    								<option value="9" <?php isArrSelEcho($res, 'iSpan', '9','selected');?>>九个月</option>
    								<option value="12" <?php isArrSelEcho($res, 'iSpan', '12','selected');?>>一年</option>
    								<option value="15" <?php isArrSelEcho($res, 'iSpan', '15','selected');?>>一年三个月</option>
    								<option value="18" <?php isArrSelEcho($res, 'iSpan', '18','selected');?>>一年六个月</option>
    								<option value="21" <?php isArrSelEcho($res, 'iSpan', '21','selected');?>>一年九个月</option>
    								<option value="24" <?php isArrSelEcho($res, 'iSpan', '24','selected');?>>二年</option>
    								<option value="27" <?php isArrSelEcho($res, 'iSpan', '27','selected');?>>二年三个月</option>
    								<option value="30" <?php isArrSelEcho($res, 'iSpan', '30','selected');?>>二年六个月</option>
    								<option value="33" <?php isArrSelEcho($res, 'iSpan', '33','selected');?>>二年九个月</option>
    								<option value="36" <?php isArrSelEcho($res, 'iSpan', '36','selected');?>>三年</option>
    							</select>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;">  
    							<label>结束时间</label>
    							<?php isArrEcho($res, 'iEnd');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>绑定用户ID</label>
    							<input type="text" name="iUserId" id="iUserId" readonly value="<?php isArrEcho($res, 'iUserId');?>" placeholder="用户ID不可编辑">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>保险人</label>
    							<select name="iInsuerId">    								
    								<?php 
    									foreach ($iRes as $ik=>$iv){
    								?>
    								<option value="<?php echo $ik;?>" <?php isArrSelEcho($res, 'iInsuerId', $ik,'selected');?>><?php echo $iv['iName'];?></option>
    								<?php 
    									}
    								?>
    							</select>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>状态</label>
    							<select name="iStatus">    								
    								<option value="1" <?php isArrSelEcho($res, 'iStatus', '1','selected');?>>投保</option>
    								<option value="0" <?php isArrSelEcho($res, 'iStatus', '0','selected');?>>未投保</option>
    							</select>
    						</fieldset>
    				</div>
        			<footer>
        				<div class="submit_link">
        					<input type="submit" value="<?php echo $_btnStr;?>" class="alt_btn" >
        					<input type="reset" value="Reset">
        					<input type="button" value="返回" onclick="history.go(-1);">
        				</div>
        			</footer>
    			</div>
    		<!-- end of #tab1 -->
    		</div>
		</form>
		<!-- end of .tab_container -->
	</article>
	
	<div class="clear"></div>
	<script>
	var _i='<?php isArrEcho($res, 'wType');?>';
	function a(){
		$('select').find('option').each(function(){
			if($(this).val()==_i){
				$(this).attr('selected',true);
				return false;
			}
		});
	}
	a();
	</script>
	
</section>