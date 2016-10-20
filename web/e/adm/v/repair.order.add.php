<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	if($_i){
	    $tObj = C('RepairOrder');
	    $res = $tObj->getRepairOrderId($_i);
	}
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">更新物流订单号</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="updateRepairOrderExpNum">
		  <input type="hidden" name="action" value="RepairOrder">
    		<div class="tab_container">
    			<div id="tab1" class="tab_content" style="display: block;">
    				<div class="module_content">    				
    				<?php 
    				if($_i){
    					//checkAdmin('1');
    					$_btnStr='保存';
    				?>
    				        <fieldset>
    							<label>ID：<?php echo $_i;?></label>										
    						</fieldset>
    				<?php 
    				}
    				?>
    						<fieldset style="width:48%;margin-right: 3%;">
    							<label>邮寄地址</label>
    							<?php isArrEcho($res, 'mAddress');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;">
    							<label>回寄地址</label>
    							<?php isArrEcho($res, 'bAddress');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;">
    							<label>上门地址</label>
    							<?php isArrEcho($res, 'cAddress');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;">
    							<label>物流单号</label>
    							<input type="text" name="roExpNum" value="<?php isArrEcho($res, 'roExpNum');?>" placeholder="请输入物流单号">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;">
    							<label>物流详细</label>
    							<textarea name="roExpContent" style="margin: 0px 10px; height: 245px; width: 575px;"><?php isArrEcho($res, 'roExpContent');?></textarea>
    						</fieldset>
    						
    				</div>
        			<footer>
        				<div class="submit_link">
        					<?php 
        					if($res['roStatus']=='2'){
        					?>
        					<input type="submit" value="<?php echo $_btnStr;?>" class="alt_btn" >
        					<input type="reset" value="Reset">
        					<?php 
        					}else{
        					?>
        					<a href="javascript:history.go(-1);" class="alt_btn" >返回</a>
        					<?php 	
        					}
        					?>
        				</div>
        			</footer>
    			</div>
    		<!-- end of #tab1 -->
    		</div>
		</form>
		<!-- end of .tab_container -->
	</article>
	
	<div class="clear"></div>
</section>