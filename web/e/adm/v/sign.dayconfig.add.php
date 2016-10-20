<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	$wObj = C('WebType');
	$wRes = $wObj->getInfiniteHtml('4','10');
	if($_i){
	    $tObj = C('SignDayConfig');
	    $res = $tObj->getSignDayConfigId($_i);
	}
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_WEBSITE,'public/js/';?>My97DatePicker/WdatePicker.js"></script>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑月份配置</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveSignDayConfig">
		  <input type="hidden" name="action" value="SignDayConfig">
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
    							<label>分类</label>
    							<?php 
    								echo $wObj->getSelectHtml($wRes);
    							?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>标题</label>
    							<input type="text" name="title" id="title" value="<?php isArrEcho($res, 'title');?>" placeholder="请输入标题 例如：01月-七天连续奖励">
    						</fieldset>    						
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>月份</label>
    							<input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM',maxDate:'#F{\'2050-10-01\'}'})" name="cDate" id="cDate" value="<?php isArrEcho($res, 'cDate');?>" placeholder="请输入月份">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>天数</label>
    							<input type="text" name="cDayNum" id="cDayNum" value="<?php isArrEcho($res, 'cDayNum');?>" placeholder="请输入天数">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>特殊节日</label>
    							<input type="text" name="cSpeDate"  onFocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{\'2050-10-01\'}'})"  id="cSpeDate" value="<?php isArrEcho($res, 'cSpeDate');?>" placeholder="请输入具体的一天">
    						</fieldset>
    				</div>
        			<footer>
        				<div class="submit_link">
        					<input type="submit" value="<?php echo $_btnStr;?>" class="alt_btn" >
        					<input type="reset" value="Reset">
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
		$('select[name="wType"]').find('option').each(function(){
			if($(this).val()==_i){
				$(this).attr('selected',true);
				return false;
			}
		});
	}
	a();
	</script>
	
</section>