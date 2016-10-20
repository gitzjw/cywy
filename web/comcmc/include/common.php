<?php
header("Content-Type: text/html; charset=GBK");
$mixchar = array('0','1','2','3','4','5','6','7','8','9','a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M',
				'n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z');

function getrealnum($mchar,$mixchar){
	$r = array_keys($mixchar,$mchar);
	if(is_array($r)){
		return $r[0];
	}
	return 0;
}
function v( $str )	{
	return isset( $_REQUEST[$str] ) ? $_REQUEST[$str] : '';
}
function mixtelnum($telnum,$dtime=0,$mixchar){
	if(strlen($telnum) != 11){
		die('请输入合适的电话号码……');
	}
	$p = $dtime%42;
	$mixtel = $mixchar[$p+3];
	for($i=1;$i<11;$i++){
		$_tmp = substr($telnum, $i,1);		
		$mixtel .= $mixchar[intval($_tmp)+$p+$i];
	}
	return $mixtel;
}

function unmixtelnum($telnum,$dtime=0,$mixchar){
	if(strlen($telnum) != 11){
		return 0;//'非法字符串……';
	}
	$p = $dtime%42;
	$ntelnum = '1';	
	for($i=1;$i<11;$i++){
		$_tmp = substr($telnum, $i,1);		
		$_i = getrealnum($_tmp,$mixchar);
		$_i = $_i-$p-$i;
		$ntelnum .= strval($_i);
	}
	return $ntelnum;
}

?>