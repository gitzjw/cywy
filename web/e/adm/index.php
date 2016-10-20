<?php
include_once '../../public/config.inc.php';
include_once '../../public/config.route.php';

header('Location:../eui/');exit();

function isArrEcho($res,$str,$eRes=''){	echo isset($res[$str])?($eRes==''?$res[$str]:$eRes):''; }
function isArrSelEcho($res,$str,$lStr,$eRes=''){	echo isset($res[$str]) && $res[$str]==$lStr?$eRes:''; }
function checkAdmin($rbac=''){
	if(empty($rbac)){
		Run::show_msg('你没有该权限，请相应管理员来进行操作');
	}
	$res = $_SESSION [APP_NAME.'_admin_'];
	if($res['uType']=='1'){
		return true;
	}
	if($res['uType']==$rbac){
		
	}else{
		Run::show_msg('你没有该权限，请相应管理员来进行操作');
	}
}

include_once 'v/header.php';
if (isset ( $_SESSION [APP_NAME.'_admin_'] )) {
	$_a = Run::req ( 'v' );
	$_a = ! empty ( $_a ) ? $_a : 'index';
	include_once 'v/' . $_a . '.php';
} else {
	include_once 'v/login.php';
}
include_once 'v/footer.php';
?>