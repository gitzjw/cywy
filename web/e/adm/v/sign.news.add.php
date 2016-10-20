<?php 
	include_once 'left_nav.php';
	$_i = Run::req('i');
	$_n = '';
	$res = '';
	$_btnStr = '添加';
	if($_i){
	    $tObj = C('SignNews');
	    $res = $tObj->getSignNewsId($_i);
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
		  <input type="hidden" name="run" value="saveSignNews">
		  <input type="hidden" name="action" value="SignNews">
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
    							<label>图片</label>
    							<input type="text" name="picUrl" id="picUrl" value="<?php isArrEcho($res, 'picUrl');?>" placeholder="图片地址">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>跳转</label>
    							<input type="text" name="hrefUrl" id="hrefUrl" value="<?php isArrEcho($res, 'hrefUrl');?>" placeholder="跳转地址">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>图文ID</label>
    							<input type="text" name="mId" id="mId" value="<?php isArrEcho($res, 'mId');?>" placeholder="图文ID">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
    							<label>发送日</label>
    							<input type="text" name="sDate"  onFocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{\'2050-10-01\'}'})"  id="sDate" value="<?php isArrEcho($res, 'sDate');?>" placeholder="请输入具体的一天">
    						</fieldset>
    						<fieldset style="width:48%;margin-right: 3%;"> 
    							<label>状态</label>
    							<select name="status">    								
    								<option value="1" <?php isArrSelEcho($res, 'status', '1','selected');?>>普通</option>
    								<option value="2" <?php isArrSelEcho($res, 'status', '2','selected');?>>默认</option>
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