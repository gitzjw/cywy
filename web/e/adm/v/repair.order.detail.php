<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	$_id = Run::req('i');
	
	include_once 'left_nav.php';
	$_tmpObj = new RepairOrderController();
	$obj = C('RepairOrderDetail');
	$res = $obj->getRepairOrderDetailOidList($_id);
	$wObj = C('WebType');
	$wRes = $wObj->getWebTypeAll('1');
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">"<?php echo $_id;?>" 产品订单详情</h3>	
			<div class="submit_a_link">
				
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">订单号</th>    
   					<th class="header">用户ID</th>
   					<th class="header">产品名称</th>
   					<th class="header">数量</th>
   					<th class="header">价格</th>
   					<th class="header">状态</th>
   					<th class="header">物流单号</th>
    				<th class="header">操作</th>  
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['oId'];?></td>
   					<td><?php echo $v['uId'];?></td>    
   					<td><?php echo $wRes[$v['wType']];?></td>   				
    				<td><?php echo $v['odNum'];?></td>
    				<td><?php echo $v['odPrice'];?></td>
    				<td><?php echo $_tmpObj->getOrderStatus($v['odStatus']);?></td>    				
    				<td><?php echo $v['odExpNum'];?></td>
    				<td><!--<a href="?v=repair.order.add&i=<?php echo $v['id'];?>">查看物流详情</a>--></td>
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
						echo Run::getPageLabel($obj->getRepairOrderDetailAllCount(), $_p, Run::$PAGE_ADMIN);
					?>		
				</div>
			</footer>
		</article>
</section>