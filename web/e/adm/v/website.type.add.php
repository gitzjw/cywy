<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	$tObj = C('WebType');
	if($_i){	    
	    $res = $tObj->getWebTypeId($_i);
	}
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
		<h3 class="tabs_involved">编辑分类</h3>
		</header>
		<form action="run.php" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="id" value="<?php echo $_i;?>">
		  <input type="hidden" name="run" value="saveWebType">
		  <input type="hidden" name="action" value="WebType">
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
    							<label>父级分类</label>
    							<?php echo $tObj->getInfiniteHtml('2');?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>分类名称</label>
    							<input type="text" name="sName" id="sName" value="<?php isArrEcho($res, 'sName');?>" placeholder="请输入分类名称">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>价格</label>
    							<select name="wStatus">    								
    								<option value="1" <?php isArrSelEcho($res, 'wStatus', '1','selected');?>>启用</option>
    								<option value="0" <?php isArrSelEcho($res, 'wStatus', '0','selected');?>>未启用</option>
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
	var _i='<?php isArrEcho($res, 'parentId');?>';
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