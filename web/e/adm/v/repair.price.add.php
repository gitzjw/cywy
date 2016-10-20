<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	$wObj = C('WebType');
	$wRes = $wObj->getInfiniteHtml('4','14');
	$wORes = $wObj->getInfiniteHtml('4','20');
	if($_i){
	    $tObj = C('RepairPrice');
	    $res = $tObj->getRepairPriceId($_i);
	}
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑价格</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveRepairPrice">
		  <input type="hidden" name="action" value="RepairPrice">
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
    							<input type="number" name="oPrice" id="oPrice" value="<?php isArrEcho($res, 'oPrice');?>" placeholder="请输入原价">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>优惠价格</label>
    							<input type="number" name="dPrice" id="dPrice" value="<?php isArrEcho($res, 'dPrice');?>" placeholder="请输入优惠幅度">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>城市</label>
    							<?php 
    								echo $wObj->getSelectHtml($wORes,'rpCity');
    							?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>分类</label>
    							<?php 
    								echo $wObj->getSelectHtml($wRes);
    							?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>价格</label>
    							<select name="rpStatus">
    								<option value="0" <?php isArrSelEcho($res, 'rpStatus', '0','selected');?>>未启用</option>
    								<option value="1" <?php isArrSelEcho($res, 'rpStatus', '1','selected');?>>启用</option>
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
	<script>
	var _i='<?php isArrEcho($res, 'wType');?>';
	$('select[name="wType"]').find('option').each(function(){
		if($(this).val()==_i){
			$(this).attr('selected',true);
			return false;
		}
	});
	var _city = '<?php isArrEcho($res, 'rpCity');?>';
	$('select[name="rpCity"]').find('option').each(function(){
		if($(this).val()==_city){
			$(this).attr('selected',true);
			return false;
		}
	});
	</script>
</section>