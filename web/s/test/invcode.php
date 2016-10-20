<?php
header ( "Content-type:text/html;charset=utf-8" );
$_arr = array ('吴占江', '王强', '温旭', '赵健飞', '侯剑楠', '郑扬', '张亮', '田毅华', '许虹', '黄文俊', '于伟男', '赵阳璞', '左莹娜', '姜政' );
function getRandomString($len = 6, $type = '1') {
	if ($type == '1') {
		$str = '0123456789';
	} elseif ($type == '2') {
		$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxzy';
	} elseif ($type == '3') {
		$str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxzy';
	}
	
	$n = $len;
	$len = strlen ( $str ) - 1;
	$s = '';
	for($i = 0; $i < $n; $i ++) {
		$s .= $str [rand ( 0, $len )];
	}
	
	return $s;
}
$sql = 'insert into shop_inv_code values';
foreach ($_arr as $v){
	$i=0;
	for(;$i<10;$i++){
		$rnd = getRandomString(6);
		$sql.='(NULL,"'.$v.'","'.$rnd.'","1"),';
	}
}
echo $sql;