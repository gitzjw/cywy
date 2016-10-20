<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	if($_i){
	    $tObj = C('SignWinRecord');
	    $res = $tObj->getSignWinRecordId($_i);
	}
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_WEBSITE,'public/js/';?>My97DatePicker/WdatePicker.js"></script>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑月份配置</h3>
			<div class="submit_a_link">
				<a href="javascript:history.go(-1);" class="alt_btn">返回</a>
			</div>		
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="updateSignWinRecord">
		  <input type="hidden" name="action" value="SignWinRecord">
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
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>用户</label>
    							<?php isArrEcho($res, 'uId');?>
    						</fieldset>    						
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>签到类型</label>
    							<?php isArrEcho($res, 'scName');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>奖励名称</label>
    							<?php isArrEcho($res, 'spName');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>发放人</label>
    							<input type="text" value="<?php isArrEcho($res, 'oUser');?>" name="oUser" placeholder="请输入操作人的名字" />
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>发放结果图</label>
    							<input type="file" name="upload" placeholder="图片地址">
    							<input type="hidden" value="<?php isArrEcho($res, 'oImg');?>" name="oImg">
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
</section>