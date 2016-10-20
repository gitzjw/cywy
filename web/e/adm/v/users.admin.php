<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('Admin');
	$res = $obj->getAdminUsersList();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">用户管理</h3>	
			<div class="submit_a_link">
				<a href="?v=users.admin.add" class="alt_btn">添加管理员</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th> 
    				<th class="header">账号</th> 
    				<th class="header">密码</th>
    				<th class="header">类型</th>
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
    				<td><?php echo $v['uName'];?></td>
    				<td><?php echo $v['uPwd'];?></td>
    				<td><?php echo $v['uType']=='1'?'系统管理员':'普通管理员';?></td>
    				<td><?php echo $v['uStatus']=='1'?'正常':'禁用';?></td>
    				<td><a href="?v=users.admin.add&i=<?php echo $v['id'];?>">编辑</a></td>
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
					<a class="alt_btn" href="?v=users.admin&page=<?php echo $_p-1>0?$_p-1:'0';?>">上一页</a>					
					<?php 
					}
					if(!empty($res)){
					?>
					<a class="alt_btn" href="?v=users.admin&page=<?php echo ++$_p;?>">下一页</a>
					<?php 
					}
					?>					
				</div>
			</footer>
		</article>
</section>