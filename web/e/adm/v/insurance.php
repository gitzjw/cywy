<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('Ins');
	$res = $obj->getInsList();
	$wObj = C('WebType');
	$wRes = $wObj->getWebTypeAll('1');
	$iObj = C('InsMember');
	$iRes = $iObj->getInsMemberAll();
	$seObj = C('SerMember');
	$seRes = $seObj->getSerMemberAll();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">保单管理</h3>	
			<div class="submit_a_link">
				<a href="?v=insurance.add" class="alt_btn">添加保单</a>
				<input type="text" value="<?php echo Run::req('keyword');?>" placeholder="请输入保单人" name="keyword">
				<a href="javascript:void(0);" onclick="window.location.href='?v=insurance.search&keyword='+$(this).prev().val();" class="alt_btn">搜索</a>
				<select id="msg_tel">
					<option value="1">短信分类</option>
					<option value="1">保单</option>
					<option value="2">出险</option>
					<option value="3">生日</option>
				</select>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
<!--   					<th class="header">编号</th>-->
   					<th class="header">保险单号</th>    			
    				<th class="header">分类</th>
    				<th class="header">服务人员</th>
    				<th class="header">开始时间</th>
    				<th class="header">结束时间</th> 
    				<th class="header">保险人</th>
    				<th class="header">更新时间</th>
    				<th class="header">绑定用户ID</th>
    				<th class="header">建立时间</th>
    				<th class="header">状态</th>
    				<th class="header">操作</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
<!--   					<td><?php echo $v['id'];?></td>    -->
   					<td><?php echo $v['iInsId'];?></td>   				
    				<td><?php echo $wRes[$v['wType']];?></td>    				
    				<td><?php echo $seRes[$v['smIdOne']]['sName'],',',$seRes[$v['smIdTwo']]['sName'];?></td>
    				<td><?php echo $v['iStart'];?></td>    
    				<td><?php echo $v['iEnd'];?></td>    
    				<td><?php echo $iRes[$v['iInsuerId']]['iName'];?></td>
    				<td><?php echo $v['iUpdateDate'];?></td>
    				<td><?php echo $v['iUserId'];?></td>
    				<td><?php echo $v['iCreateDate'];?></td>
    				<td><?php echo $v['iStatus']=='0'?'<font style="color:red">未投保</font>':'投保中';?></td>
    				<td><a href="?v=insurance.add&i=<?php echo $v['id'];?>">编辑</a><!--
    				 | <a href='javascript:void(0);' onclick='del("Ins","delIns","<?php echo $v['id']?>")'>删除</a> -->
    				  | <a href='javascript:void(0);' onclick='msg("Ins","messageIns","<?php echo $v['id']?>")'>短信</a>
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
					echo Run::getPageLabel($obj->getInsAllCount(), $_p, Run::$PAGE_ADMIN);
				?>
				</div>
			</footer>
		</article>
</section>