<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	if($_i){
	    $tObj = C('InsPrice');
	    $res = $tObj->getInsPriceId($_i);
	}
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑价格</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveInsPrice">
		  <input type="hidden" name="action" value="InsPrice">
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
    							<label>原价</label>
    							<input type="number" name="pPrice" id="pPrice" value="<?php isArrEcho($res, 'pPrice');?>" placeholder="请输入原价">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>优惠价格</label>
    							<input type="number" name="pDis" id="pDis" value="<?php isArrEcho($res, 'pDis');?>" placeholder="请输入优惠幅度">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>时长</label>
    							<input type="number" name="pSpan" id="pSpan" value="<?php isArrEcho($res, 'pSpan');?>" placeholder="请输入天数">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>价格</label>
    							<select name="pStatus">
    								<option value="0" <?php isArrSelEcho($res, 'pStatus', '0','selected');?>>未启用</option>
    								<option value="1" <?php isArrSelEcho($res, 'pStatus', '1','selected');?>>启用</option>
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