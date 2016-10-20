<?php
/*$a=4;
$b=6;

if($a=10||$b=10){	
    $a++;
    $b++;
}
echo $a,'    ',$b;*/

//$_dateEnd = date ( "Y-m-d H:i:s", strtotime ( "-1 day", strtotime ( "+3 months", strtotime ( '2016-11-04 10:06:29' ) ) ) );
//echo $_dateEnd;


//echo date('Y-m',strtotime("+1 months",strtotime('2015-12')));
//$b = 1;
//$a = $b;
//if ( $b = 2 && $a = 3) {
//	var_dump($b,$a);	
//	$a ++;
//	$b ++;
//}
//echo ($a . $b);


//echo 39.00-38.99;
//echo '99999999999999999999'-1;
//var_dump(strval(doubleval('99999999999999999999') - doubleval('1')));
//echo number_format(1.0E+20);
/*$num = number_format('99999999999999999999','','',''); //后面三个参数为默认值
var_dump($num); //输出“123,132,231,234,230,000”*/

/*$_key = 'jCTVfkOz2nQPLBwYM2f1as4MtFTe9wm9';

$data ['agentid'] = 147;
$data ['uid'] = 123546789;
$data ['serverid'] = 14874;
$data ['time'] = time ();
//sign 加密规则 agentid+uid+serverid+time+key
$data ['sign'] = md5 ( $data ['agentid'] . $data ['uid'] . $data ['serverid'] . $data ['time'] . $_key );
$data ['json'] = 1;

$_params = http_build_query ( $data );

//echo $_params;

$_loginUrl = 'http://hf.wan95.com/api/togame?'.$_params;
echo $_loginUrl,'<br>';

$_findRoleUrl = 'http://hf.wan95.com/api/getrole?'.$_params;
echo $_findRoleUrl;*/

//echo rand(1, 5);
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
	$_arr = array();
	for($i=0;$i<10000;$i++){
		$_str = getRandomString(8,1);
		$_arr[$_str]=$i;
//		echo getRandomString(),'<br>';
	}
echo (count($_arr));