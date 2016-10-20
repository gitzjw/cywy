<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('InsMember');
	$imRes = $obj->getInsMemberName(Run::req('keyword'));
	$res[] = $imRes;
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">保单人管理</h3>	
			<div class="submit_a_link">
				<a href="?v=insurance.member.add" class="alt_btn">添加保单人</a>
				<input type="text" value="<?php echo Run::req('keyword');?>" placeholder="请输入保单人" name="keyword">
				<a href="javascript:void(0);" onclick="window.location.href='?v=insurance.member.search&keyword='+$(this).prev().val();" class="alt_btn">搜索</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>     				
    				<th class="header">姓名</th>
    				<th class="header">性别</th>
    				<th class="header">年龄</th>
    				<th class="header">身份证</th> 
    				<th class="header">电话</th>
    				<th class="header">绑定用户ID</th>
    				<th class="header">操作</th>  
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td>     				
    				<td><?php echo $v['iName'];?></td>
    				<td><?php echo $v['iSex']=='1'?'男':'女';?></td>
    				<td><?php echo $v['iAge'];?></td>
    				<td><?php echo $v['iIdCard'];?></td>    
    				<td><?php echo $v['iTelNumber'];?></td>    
    				<td><?php echo $v['iUserId'];?></td>
    				<td><a href="?v=insurance.member.add&i=<?php echo $v['id'];?>">编辑</a><!--
    				 | <a href='javascript:void(0);' onclick='del("InsMember","delInsMember","<?php echo $v['id']?>")'>删除</a>
    				 --></td>
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
				</div>
			</footer>
		</article>
</section>