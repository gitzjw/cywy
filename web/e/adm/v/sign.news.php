<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('SignNews');
	$res = $obj->getSignNewsList();
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">签到推送新闻列表</h3>	
			<div class="submit_a_link">
				<a href="?v=sign.news.add" class="alt_btn">添加推送新闻</a>
				<!--<input type="text" value="<?php echo Run::req('keyword');?>" placeholder="请输入月份  例如：2015-01" name="keyword">
				<a href="javascript:void(0);" onclick="window.location.href='?v=sign.dayconfig.search&keyword='+$(this).prev().val();" class="alt_btn">搜索</a>
			--></div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th class="header">编号</th>
   					<th class="header">标题</th>    			
    				<th class="header">发送日</th>
    				<th class="header">图片</th>
    				<th class="header">跳转地址</th>
    				<th class="header">图文ID</th>
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
   					<td><?php echo $v['title'];?></td>   		
    				<td><?php echo $v['sDate'];?></td>    
    				<td><?php echo '<a href="',$v['picUrl'],'" target="_blank">点击查看</a>';?></td>
    				<td><?php echo '<a href="',$v['hrefUrl'],'" target="_blank">点击查看</a>';?></td>
    				<td><?php echo $v['mId'];?></td>    
    				<td><?php echo $v['status']=='1'?'普通':'默认发送';?></td>
    				<td>
    					<a href="?v=sign.news.add&i=<?php echo $v['id'];?>">编辑</a>
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
					echo Run::getPageLabel($obj->getSignNewsAllCount(), $_p, Run::$PAGE_ADMIN);
				?>
				</div>
			</footer>
		</article>
</section>