<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	if($_i){
	    $tObj = C('InsMember');
	    $res = $tObj->getInsMemberId($_i);
	}
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑保单人</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveInsMember">
		  <input type="hidden" name="action" value="InsMember">
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
    							<label>姓名</label>
    							<input type="text" name="iName" id="iName" value="<?php isArrEcho($res, 'iName');?>" placeholder="请输入姓名">
    						</fieldset>    						
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>身份证</label>
    							<input type="text" name="iIdCard" id="iIdCard" value="<?php isArrEcho($res, 'iIdCard');?>" placeholder="请输入身份证">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>性别</label>
    							<!-- 
    							<input type="radio" name="iSex" value="0"  <?php isArrSelEcho($res, 'iSex', '0','checked');?>>女
    							<input type="radio" name="iSex" value="1"  <?php isArrSelEcho($res, 'iSex', '1','checked');?>>男
    							 -->
    							  <?php isArrSelEcho($res, 'iSex', '1','男');isArrSelEcho($res, 'iSex', '0','女');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>年龄</label>
<!--    							<input type="number" readonly max="60" min="18" style="width:200px"; name="iAge" id="iAge" value="<?php isArrEcho($res, 'iAge');?>" placeholder="请输入年龄（18-60）">-->
								<?php isArrEcho($res, 'iAge');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>电话</label>
    							<input type="text" name="iTelNumber" id="iTelNumber" value="<?php isArrEcho($res, 'iTelNumber');?>" placeholder="请输入电话">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>地址</label>
    							<input type="text" name="iAddress" id="iAddress" value="<?php isArrEcho($res, 'iAddress');?>" placeholder="请输入联系地址">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>绑定用户ID</label>
    							<input type="text" name="iUserId" id="iUserId" value="<?php isArrEcho($res, 'iUserId');?>" readonly placeholder="用户ID不可编辑">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>状态</label>
    							<select name="iuStatus">    								
    								<option value="1" <?php isArrSelEcho($res, 'iuStatus', '2','selected');?>>启用</option>
    								<option value="0" <?php isArrSelEcho($res, 'iuStatus', '1','selected');?>>未启用</option>
    							</select>
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