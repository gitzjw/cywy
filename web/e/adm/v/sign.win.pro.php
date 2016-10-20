<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('SignWinPro');
	$res = $obj->getSignWinProList();
	$wObj = C('WebType');
	$wRes = $wObj->getWebTypeAll('1');
	$sdObj = C('SignDayConfig');
	$sdRes = $sdObj->getSignDayConfigAll();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">每月奖励物品</h3>	
			<div class="submit_a_link">
				<a href="?v=sign.win.pro.add" class="alt_btn">添加奖励物品</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>
   					<th class="header">标题</th>    			
    				<th class="header">副标题</th>
    				<th class="header">图片</th>
    				<th class="header">类型</th>
    				<th class="header">所属奖励</th> 
    				<th class="header">其它</th>
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
   					<td><?php echo $v['subTitle'];?></td>   
   					<td><?php echo '<a href="'.$v['imgPath'].'" target="_blank">点击查看</a>';?></td>	   				
    				<td><?php echo $wRes[$v['wType']];?></td>
    				<td><?php echo $sdRes[$v['scId']]['title'];?></td>    
    				<td><?php echo $v['oMark'];?></td>
    				<td><a href="?v=sign.win.pro.add&i=<?php echo $v['id'];?>">编辑</a>
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
					echo Run::getPageLabel($obj->getSignWinProAllCount(), $_p, Run::$PAGE_ADMIN);
				?>
				</div>
			</footer>
		</article>
</section>