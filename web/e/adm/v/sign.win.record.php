<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('SignWinRecord');
	$res = $obj->getSignWinRecordList();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">全部奖励记录</h3>	
			<div class="submit_a_link">
				<!--
				<input type="text" value="<?php echo Run::req('keyword');?>" placeholder="请输入月份  例如：2015-01" name="keyword">
				<a href="javascript:void(0);" onclick="window.location.href='?v=sign.dayconfig.search&keyword='+$(this).prev().val();" class="alt_btn">搜索</a>
				-->
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>
   					<th class="header">用户</th>    			
    				<th class="header">签到类型</th>
    				<th class="header">奖品名称</th>
    				<th class="header">创建时间</th>
    				<th class="header">发放人</th>
    				<th class="header">发放结果</th>
    				<th class="header">操作</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php 
			foreach ($res as $k=>$v){
			?>
				<tr> 
   					<td><?php echo $v['id'];?></td>    
   					<td onmouseup="userDetail('<?php echo $v['uId'];?>')"><?php echo $v['uId'];?></td>   		
    				<td><?php echo $v['scName'];?></td>
    				<td><?php echo $v['spName'];?></td>
    				<td><?php echo $v['createDate'];?></td>
    				<td><?php echo $v['oUser']==''?'系统':$v['oUser'];?></td>
    				<td><a href="<?php echo $v['oImg'];?>" target="_blank">点击查看</a></td>
    				<td>
    					<a href="?v=sign.win.record.add&i=<?php echo $v['id'];?>">发放奖励</a>
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
					echo Run::getPageLabel($obj->getSignWinRecordAllCount(), $_p, Run::$PAGE_ADMIN);
				?>
				</div>
			</footer>
		</article>
		
		<div id="udt"></div>
</section>