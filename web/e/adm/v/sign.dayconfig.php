<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$wObj = C('WebType');
	$wRes = $wObj->getWebTypeAll('1');
	$obj = C('SignDayConfig');
	$res = $obj->getSignDayConfigList();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">每月配置奖励</h3>	
			<div class="submit_a_link">
				<a href="?v=sign.dayconfig.add" class="alt_btn">添加配置</a>
				<!--<input type="text" value="<?php echo Run::req('keyword');?>" placeholder="请输入月份  例如：2015-01" name="keyword">
				<a href="javascript:void(0);" onclick="window.location.href='?v=sign.dayconfig.search&keyword='+$(this).prev().val();" class="alt_btn">搜索</a>
			--></div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>
   					<th class="header">标题</th>  
   					<th class="header">类型</th>  			
    				<th class="header">月份</th>
    				<th class="header">天数</th>
    				<th class="header">特殊节日</th>
    				<th class="header">操作</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td>    
   					<td><?php echo $v['title'];?></td>   	
   					<td><?php echo $wRes[$v['wType']];?></td>	
    				<td><?php echo $v['cDate'];?></td>    
    				<td><?php echo $v['cDayNum'],'天';?></td>    
    				<td><?php echo $v['cSpeDate'];?></td>
    				<td>
    					<a href="?v=sign.dayconfig.add&i=<?php echo $v['id'];?>">编辑</a>
    				</td>
				</tr>
			<?php 
			}
			?>				 
			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
						
		</div><!-- end of .tab_container -->
		<footer>
				<div class="submit_link">
				<?php 
					echo Run::getPageLabel($obj->getSignDayConfigAllCount(), $_p, Run::$PAGE_ADMIN);
				?>
				</div>
			</footer>
		</article>
</section>