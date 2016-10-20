<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('RepairOrder');
	$res = $obj->getRepairOrderList();
	$wObj = C('WebType');
	$wRes = $wObj->getWebTypeAll('1');
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">产品订单</h3>	
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
   					<th class="header">城市</th>
   					<th class="header">服务方式</th>   					
   					<th class="header">价格</th>
   					<th class="header">状态</th>
   					<th class="header">物流单号</th>
   					<th class="header">创建时间</th>
   					<th class="header">支付时间</th>
   					<th class="header">交易流水号</th>
    				<th class="header">操作</th>  
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td>
   					<td><?php echo $v['uId'];?></td>
   					<td><?php echo $wRes[$v['roCity']];?></td>    
   					<td><?php echo $wRes[$v['wType']];?></td>   				
    				<td><?php echo $v['roPrice'];?></td>
    				<td><?php echo $obj->getOrderStatus($v['roStatus']);?></td>    				
    				<td><?php echo $v['roExpNum'];?></td>			
    				<td><?php echo $v['roCreateDate'];?></td>
    				<td><?php echo $v['roPayDate'];?></td>
    				<td><?php echo $v['roPayCode'];?></td>
    				<td><a href="?v=repair.order.add&i=<?php echo $v['id'];?>">查看</a> | 
    				<a href="javascript:orderDetail('<?php echo $v['id'];?>')">详情</a> | 
    				<a href="?v=repair.order.detail&i=<?php echo $v['id'];?>">子订单</a>
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
						echo Run::getPageLabel($obj->getRepairOrderAllCount(), $_p, Run::$PAGE_ADMIN);
					?>		
				</div>
			</footer>
		</article>
		
		<div id="odt"></div>
</section>