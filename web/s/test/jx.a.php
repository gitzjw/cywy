<?php
header ( "Content-type:text/html;charset=utf-8" );
include_once __DIR__ . '/../../m/DB.php';
$_codeRes = file_get_contents ( 'jx.a.txt' );
$_codeRes = explode ( "\n", $_codeRes );

$db = new Mysql ();

foreach ( $_codeRes as $k => $v ) {
//	$_tmp = explode("	", $v);
//	$sql = 'select * from shop_pro_400001 where id="'.$_tmp['0'].'" ';
//	$_one = $db->get_one($sql);
//	unset($_one['id']);
//	$_one['wType'] = $_tmp['1'];
//	$_one['spContent'] = $_one['spContent'];
//	$db->insert('shop_pro_400001', $_one);
//	echo $k+1;
}