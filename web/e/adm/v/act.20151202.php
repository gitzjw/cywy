<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('Activity');
	$res = $obj->getActivityList('20151202');
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">2015-12-02 活动报名</h3>	
			<div class="submit_a_link">
				<!--<a href="?v=Activity.admin.add" class="alt_btn">添加管理员</a>-->
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th> 
    				<th class="header">姓名</th> 
    				<th class="header">电话</th>
    				<th class="header">店名</th>
    				<th class="header">从业年限/年</th>
    				<th class="header">等级</th>
    				<th class="header">自我介绍</th>
    				<th class="header">报名时间</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td> 
    				<td><?php echo $v['xm'];?></td>
    				<td><?php echo $v['tel'];?></td>
    				<td><?php echo $v['shop'];?></td>
    				<td><?php echo $v['exp'];?></td>
    				<td><?php echo $v['lv'];?></td>    				
    				<td><?php echo $v['content'];?></td>
    				<td><?php echo $v['cdate'];?></td>
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
						echo Run::getPageLabel($obj->getActivityAllCount('20151202'), $_p, Run::$PAGE_ADMIN);
					?>		
				</div>
			</footer>
		</article>
</section>