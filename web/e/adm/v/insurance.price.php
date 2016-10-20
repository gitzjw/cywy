<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('InsPrice');
	$res = $obj->getInsPriceList();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">价格管理</h3>	
			<div class="submit_a_link">
				<a href="?v=insurance.price.add" class="alt_btn">添加价格</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>     				
    				<th class="header">原价</th>
    				<th class="header">优惠</th>
    				<th class="header">最终价格</th>
    				<th class="header">时长(月)</th> 
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
    				<td><?php echo $v['pPrice'];?></td>
    				<td><?php echo $v['pDis'];?></td>    				
    				<td><?php echo $v['pNPrice'];?></td>
    				<td><?php echo $v['pSpan'];?></td>				
    				<td><?php echo $v['pStatus']=='1'?'启用':'未启用';?></td>
    				<td><a href="?v=insurance.price.add&i=<?php echo $v['id'];?>">编辑</a></td>
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
					if($_p!='0'){
					?>
					<a class="alt_btn" href="?v=insurance.price&page=<?php echo $_p-1>0?$_p-1:'0';?>">上一页</a>					
					<?php 
					}
					if(!empty($res)){
					?>
					<a class="alt_btn" href="?v=insurance.price&page=<?php echo ++$_p;?>">下一页</a>
					<?php 
					}
					?>					
				</div>
			</footer>
		</article>
</section>