<?php
header ( "Content-type:text/html;charset=utf-8" );
include_once __DIR__ . '/../../m/DB.php';
$_codeRes = file_get_contents ( 'updateMarketPrice.txt' );
$_codeRes = explode ( "\n", $_codeRes );

var_dump ( $_codeRes );
exit ();

$db = new Mysql ();
//$sql = 'update shop_pro_100001 set spStatus="2" where id not in (';
foreach ( $_codeRes as $k => $v ) {
	$_tmp = explode('	', $v);
	$_d ['marketPrice'] = $_tmp [0];
//	$_d ['sUnitNum'] = $_tmp [2];
//	$_d ['spStatus'] = '1';
//	var_dump($_tmp);
	$res = $db->update ( 'shop_pro_400001', $_d, ' sptm="' . trim($_tmp [1]) . '"' );
	echo $k,'<br>';
	var_dump($res);
//	$sql .= $_tmp [1].',';
	
}
//$sql .= ')';

//echo $sql;
?>