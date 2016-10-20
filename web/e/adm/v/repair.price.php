<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('RepairPrice');
	$res = $obj->getRepairPriceList();
	$wObj = C('WebType');
	$wRes = $wObj->getWebTypeAll('1');
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">维修价格管理</h3>	
			<div class="submit_a_link">
				<a href="?v=repair.price.add" class="alt_btn">添加维修价格</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>    
   					<th class="header">城市</th>
   					<th class="header">产品</th> 				
    				<th class="header">原价</th>
    				<th class="header">优惠</th>
    				<th class="header">最终价格</th>    				 
    				<th class="header">状态</th>
    				<th class="header">操作</th>  
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td>
   					<td><?php echo $wRes[$v['rpCity']];?></td>  
   					<td><?php echo $wRes[$v['wType']];?></td>   				
    				<td><?php echo $v['oPrice'];?></td>
    				<td><?php echo $v['dPrice'];?></td>    				
    				<td><?php echo $v['nPrice'];?></td>			
    				<td><?php echo $v['rpStatus']=='1'?'启用':'未启用';?></td>
    				<td><a href="?v=repair.price.add&i=<?php echo $v['id'];?>">编辑</a></td>
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
						echo Run::getPageLabel($obj->getRepairPriceAllCount(), $_p, Run::$PAGE_ADMIN);
					?>		
				</div>
			</footer>
		</article>
</section>