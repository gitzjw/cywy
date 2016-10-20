<?php 
	$_url = $_SERVER['REQUEST_URI'];
	$_p = Run::req('page');
	$_p = empty($_p)?0:$_p;
	
	include_once 'left_nav.php';
	$obj = C('WebType');
?>
<section id="main" class="column">
	<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved">分类管理</h3>	
			<div class="submit_a_link">
				<a href="?v=website.type.add" class="alt_btn">添加分类</a>
			</div>	
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content" style="display: block;">
			<h2 style="margin-left:100px;">
				<?php echo $obj->getInfiniteHtml();?>
			</h2>
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
					if(false){
					?>
					<a class="alt_btn" href="?v=insurance.price&page=<?php echo ++$_p;?>">下一页</a>
					<?php 
					}
					?>					
				</div>
			</footer>
		</article>
</section>