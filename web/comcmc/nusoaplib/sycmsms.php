<?php
set_time_limit(0);

header("Content-Type: text/html; charset=GBK");

function getSMSContent($type,$telnum){
	$result = '';
	switch ($type){
		case 'sjyz':
			{
				$result = '�ֻ���֤��Ϊ��'.$telnum.'����л�������ֻ��󶨣�����֤���ʱ������Ч����Ǳ��˲���������Ա���Ϣ��˫��13������';
			}
			break;
		case 'sjfs':
			{
				$result = '˫��13����֪ͨ��,'.$telnum.' �뼰ʱ��¼�޸ģ������������⣬�뼰ʱ��ϵ�ͷ���Ա����0000���ա�˫��13������';
			}
			break;
		case 'sjall':
			{
				$result = $telnum.'��0000���ա�˫��13������';
			}
			break;
		case 'rwdx':
			{
				$result = '�ֻ���֤��Ϊ��'.$telnum.'����л�������ֻ��󶨣�����֤��10��������Ч����Ǳ��˲���������Ա���Ϣ�����������';
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
	$serialNumber = '7SDK-LHW-0588-NBQOM';
	$password = '';
	$sessionKey = 'sycm1113wlb';
	$connectTimeOut = 2;
	$readTimeOut = 10;
	$proxyhost = false;
	$proxyport = false;
	$proxyusername = false;
	$proxypassword = false;
	$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
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
