<?php
header("Content-type:text/html;charset=utf-8");
$hd =fopen('abc.txt', 'r');
$_typeT=0;
$_arr = array();
$_arr1 = array();
while (!feof($hd)){
	$_str = fgets($hd);
	$_tmp = explode('	', $_str);
	
	$_arr[strval($_tmp[0])][strval($_tmp[1])] += intval($_tmp[3]);
	
	$_arr1[strval($_tmp[1])][strval($_tmp[2])] = intval($_tmp[3]);
}

//var_dump($_arr);
//var_dump(implode('","', array_keys($_arr['主粮'])));
print_r($_arr1);