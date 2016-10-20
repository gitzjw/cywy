<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('Users');
	$res = $obj->getUsersList();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">用户管理</h3>	
			<div class="submit_a_link">
<!--				<a href="?v=users.admin.add" class="alt_btn">添加管理员</a>-->
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th> 
    				<th class="header">身份证</th> 
    				<th class="header">电话号码</th>
    				<th class="header">OPENID</th>
    				<th class="header">来源</th>
    				<th class="header">注册时间</th>
    				<th class="header">状态</th> 
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td onmouseup="userDetail('<?php echo $v['id'];?>')"><?php echo $v['id'];?></td> 
    				<td><?php echo $v['idCard'];?></td>
    				<td><?php echo $v['telNumber'];?></td>
    				<td><?php echo $v['openId'];?></td>
    				<td><?php echo $v['uType']=='1'?'微信':'未知';?></td>
    				<td><?php echo $v['uCreateDate'];?></td>    				
    				<td><?php echo $v['uStatus']=='1'?'正常':'禁用';?></td>
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
						echo Run::getPageLabel($obj->getUsersAllCount(), $_p, Run::$PAGE_ADMIN);
					?>		
				</div>
			</footer>
		</article>
		
		<div id="udt"></div>
</section>