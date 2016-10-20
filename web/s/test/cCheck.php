<?php
header ( "Content-type:text/html;charset=utf-8" );
include_once __DIR__ . '/../../m/DB.php';
//$_codeRes = file_get_contents ( 'c30001.txt' );
//$_codeRes = explode ( "\n", $_codeRes );

$db = new Mysql ();
$_mainType = array ('1' => '主粮', '6' => '零食', '7' => '日用', '8' => '玩具', '9' => '医疗', '10' => '牵引', '11' => '香波', '101' => '工具' );


$_arr = array ();
//foreach ( $_codeRes as $k => $v ) {
	$sql = 'SELECT s1.id,s1.title,s1.nPrice,s1.oPrice,s1.sptm,s1.spStatus,s1.sUnitNum,s1.sUnit,s1.sNorms,st.id AS stid,st.parentId,st.sName FROM shop_pro_100001 s1 ,shop_type st WHERE s1.wType=st.id ';
	//	echo $sql,'<br>';
	$res = $db->get_all ( $sql );
	//	var_dump($res);
	
//	$_tmpSql = 'select * from shop_pro_100001 where id not in (';
	foreach ($res as $k=>$v){
		if($v['spStatus']=='1'){
			$_str = '上架';
		}else{
			$_str = '下架';
		}
		$v['spStatusName'] = $_str;
		$_arr [$_mainType [$v ['parentId']]] [$v ['sName']] [] = $v;
//		$_tmpSql.= $v['id'].',';
	}
//	$_tmpSql.=')';
//	echo $_tmpSql;exit();
//}

//var_dump ( $_arr );

//	$_num = 0;

foreach ( $_arr as $k => $vv ) {
	echo '<table border="1px">';
	echo '<tr><td colspan="5">' . $k . '</td></tr>';
	foreach ( $vv as $k => $vvv ) {
		echo '<tr><td>&nbsp;</td><td colspan="4">' . $k . '</td></tr>';
		foreach ( $vvv as $vvvv ) {
//			++$_num;
			echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>' . $vvvv ['id'] . '</td><td>' . $vvvv ['title'] . '</td>
			<td>' . $vvvv ['oPrice'] . '</td><td>' . $vvvv ['nPrice'] . '</td><td>' . $vvvv ['sptm'] . '</td>
			<td>' . $vvvv ['sNorms'] . '</td><td>' . $vvvv ['sUnit'] . '</td><td>' . $vvvv ['sUnitNum'] . '</td>
			<td>' . $vvvv ['spStatusName'] . '</td>
			</tr>';
		}
	}
	echo '</table>';
}

//echo $_num;

?>


