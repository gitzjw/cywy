<?php
set_time_limit(0);

header("Content-Type: text/html; charset=GBK");

function getSMSContent($type,$telnum){
	$result = '';
	switch ($type){
		case 'utmb':
			{
				$result = $telnum;
			}
			break;
		case 'mmd':
			{
				$result = '�ֻ���֤��Ϊ��'.$telnum.'����Ǳ��˲���������Ա���Ϣ�������ա�';
			}
			break;
		default:
				break;
	}
	return $result;
}
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once SCRIPT_ROOT.'include/common.php';

$type = v('y');
$ntel = v('t');
$dtime = v('d');
$_tmp = v('n');
$enc = v('enc');
if(empty($type) || empty($ntel) || empty($dtime) || empty($_tmp)){
	echo '������ȫ';exit;
}
if(empty($enc)){
	$enc = false;
}

$telnumber = unmixtelnum($ntel,$dtime,$mixchar);
if($enc){
	$dnum = iconv('utf-8', 'gbk', urldecode(v('n')));
}else {
	$dnum = v('n');
}


/*��ʼ���ض��ŷ�������*/
require_once SCRIPT_ROOT.'include/client.php';
	$gwUrl = 'http://sdk.univetro.com.cn:6200/sdk/SDKService';
	$serialNumber = '7SDK-LHW-0588-QDZNQ';
	$password = '780405';
	$sessionKey = 'sycm1118mgswlb';
	$connectTimeOut = 2;
	$readTimeOut = 10;
	$proxyhost = false;
	$proxyport = false;
	$proxyusername = false;
	$proxypassword = false;
	$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
	//$client->login('sycm1118mgswlb');
	$client->setOutgoingEncoding("GBK");

function sendSMS($telarray,$scontent){
	if(empty($scontent)){
		echo '�������ݲ���Ϊ�ա���';exit;
	}
	global $client;		
	$statusCode = $client->sendSMS($telarray,$scontent);
	return $statusCode;
}

$tela[] =strval($telnumber);
$result = sendSMS($tela,getSMSContent($type,$dnum));
if(strval($result) == '0'){
	echo '00';
}else{
	echo $result;
}
?>
