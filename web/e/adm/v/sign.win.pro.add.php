<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	$wObj = C('WebType');
	$wRes = $wObj->getInfiniteHtml('4','7');
	$sdObj = C('SignDayConfig');
	$sdRes = $sdObj->getSignDayConfigDate();
	if($_i){
	    $tObj = C('SignWinPro');
	    $res = $tObj->getSignWinProId($_i);
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
		  <input type="hidden" name="run" value="saveSignWinPro">
		  <input type="hidden" name="action" value="SignWinPro">
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
    							<label>标题</label>
    							<input type="text" name="title" id="title" value="<?php isArrEcho($res, 'title');?>" placeholder="请输入标题 例如：新闻标题">
    						</fieldset>    						
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>副标题</label>
    							<input type="text" name="subTitle" id="subTitle" value="<?php isArrEcho($res, 'subTitle');?>" placeholder="请输入副标题">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>奖励推送</label>
    							<input type="text" name="winMsg" id="winMsg" value="<?php isArrEcho($res, 'winMsg');?>" placeholder="请输入奖励推送">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>内容</label>
    							<textarea rows="6" cols="" name="content"><?php isArrEcho($res, 'content');?></textarea>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>月份</label>
    							<input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM',maxDate:'#F{\'2050-10-01\'}'})" name="cDate" id="cDate" value="<?php isArrEcho($res, 'cDate');?>" placeholder="请输入月份">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>图片</label>
    							<input type="file" name="upload" placeholder="图片地址">
    							<input type="hidden" value="<?php isArrEcho($res, 'imgPath');?>" name="imgPath">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>分类</label>
    							<?php 
    								echo $wObj->getSelectHtml($wRes);
    							?>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>所属奖励</label>
    							<select name="scId">
    								<?php 
    									foreach ($sdRes as $sk=>$sv){
    								?>
    								<option value="<?php echo $sv['id'];?>" <?php isArrSelEcho($res, 'scId', $sv['id'],'selected');?>><?php echo $sv['title'];?></option>
    								<?php 
    									}
    								?>
    							</select>
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>其它（如果是虚拟物品，请填写相关虚拟物品ID）</label>
    							<input type="text" name="oMark" id="oMark" value="<?php isArrEcho($res, 'oMark');?>" placeholder="可以为空">
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