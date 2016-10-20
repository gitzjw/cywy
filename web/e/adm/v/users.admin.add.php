<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	if($_i){
	    $tObj = C('Admin');
	    $res = $tObj->getAdminUsersId($_i);
	}
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">添加管理员</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveAdminUsers">
		  <input type="hidden" name="action" value="Admin">
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
    							<label>用户名</label>
    							<input type="text" name="uName" id="uName" value="<?php isArrEcho($res, 'uName');?>" <?php isArrEcho($res, 'uName','readonly');?> placeholder="请输入用户名">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>密码</label>
    							<input type="password" name="uPwd" id="uPwd" value="<?php isArrEcho($res, 'uPwd');?>" placeholder="请输入密码">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>类型</label>
    							<select name="uType">
    								<option value="1" <?php isArrSelEcho($res, 'uType', '1','selected');?>>系统管理员</option>
    								<option value="2" <?php isArrSelEcho($res, 'uType', '2','selected');?>>普通管理员</option>
    							</select>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>状态</label>
    							<select name="uStatus">
    								<option value="1" <?php isArrSelEcho($res, 'uStatus', '1','selected');?>>正常</option>
    								<option value="2" <?php isArrSelEcho($res, 'uStatus', '2','selected');?>>禁用</option>
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