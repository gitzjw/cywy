<?php 
unset($_SESSION[APP_NAME.'_admin_']);
$_an = Run::req('uname');
if(!empty($_an)){
	$obj = C('Admin');
	$res = $obj->loginAdminUsers();
}
?>
<form action="" method="post">
<article class="module width_full" style="margin-left:23%;margin-top:10%;width:900px;">
	<header><center><h3>登录</h3></center></header>
		<div class="module_content">
				<fieldset>
					<label>用户名：</label>
					<input type="text" name="uname" >
				</fieldset>
				<fieldset>
					<label>密码：</label>
					<input type="password" name="pwd">
				</fieldset>
		</div>
	<footer>
		<div class="submit_link">
			<input type="submit" value="Login" class="alt_btn">
			<input type="submit" value="Reset">
		</div>
	</footer>
</article>
</form>