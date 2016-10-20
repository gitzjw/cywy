<?php 
$_rightTitle = Run::req('title');
$_rightTitle = empty($_rightTitle)?'内容':$_rightTitle;
?>
<section id="secondary_bar">
	<div class="user">
		<p><?php echo $_SESSION [APP_NAME.'_admin_']['uName'];?><a href="#"></a></p>
		<a class="logout_user" href="?v=login" title="Logout">Logout</a>
	</div>
	<div class="breadcrumbs_container">
		<article class="breadcrumbs"><a href="#">主视图</a> <div class="breadcrumb_divider"></div> <a class="current"><?php echo $_rightTitle;?></a></article>
	</div>
</section>
<aside id="sidebar" class="column">
	<form class="quick_search">
		<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
	</form>
	<hr/>
	<h3>用户</h3>
	<ul class="toggle">
		<li class="icn_view_users"><a href="?v=users.reg">注册用户</a></li>
	</ul>
	<hr/>
	<h3>保险单</h3>
	<ul class="toggle">		
		<li class="icn_categories"><a href="?v=insurance">保单信息</a></li>
		<li class="icn_categories"><a href="?v=insurance.pay.record">支付记录</a></li>
		<li class="icn_view_users"><a href="?v=insurance.member">保单人</a></li>
		<li class="icn_categories"><a href="?v=insurance.price">价格配置</a></li>		
	</ul>
	<hr/>
	<h3>服务</h3>
	<ul class="toggle">
		<li class="icn_view_users"><a href="?v=service.member">服务人员</a></li>
	</ul>
	<hr/>
	<h3>签到系统</h3>
	<ul class="toggle">
		<li class="icn_categories"><a href="?v=sign.dayconfig">配置月份</a></li>
		<li class="icn_categories"><a href="?v=sign.news">新闻推送</a></li>
		<li class="icn_categories"><a href="?v=sign.win.pro">奖品配置</a></li>
		<li class="icn_categories"><a href="?v=sign.main">签到用户</a></li>
		<li class="icn_categories"><a href="?v=sign.main.record">签到记录</a></li>
		<li class="icn_categories"><a href="?v=sign.win.record">奖励记录</a></li>
	</ul>
	<hr/>
	<h3>维修产品</h3>
	<ul class="toggle">
		<li class="icn_categories"><a href="?v=repair.price">价格配置</a></li>
		<li class="icn_categories"><a href="?v=repair.order">产品订单</a></li>
	</ul>
	<hr/>
	<h3>活动</h3>
	<ul class="toggle">
		<li class="icn_view_users"><a href="?v=act.20151202">20151202</a></li>
	</ul>
	<hr/>
	<h3>系统</h3>
	<ul class="toggle">
		<li class="icn_categories"><a href="?v=website.type">系统分类</a></li>
		<?php 
		if($_SESSION [APP_NAME.'_admin_']['uType']=='1'){
		?>
		<li class="icn_view_users"><a href="?v=users.admin">管理员</a></li>
		<?php 
		}
		?>
	</ul>
	<footer>
		<hr />
		<p><strong>Copyright &copy; 2015 mgs.momoday.net MGS</strong></p>
	</footer>
</aside><!-- end of sidebar -->
