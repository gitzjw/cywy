<?php
set_time_limit(0);

header("Content-Type: text/html; charset=GBK");

function getSMSContent($type,$telnum){
	$result = '';
	switch ($type){
		case 'sjyz':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码短时间内有效。如非本人操作，请忽略本信息【双井13社区】';
			}
			break;
		case 'sjfs':
			{
				$result = '双井13社区通知您,'.$telnum.' 请及时登录修改，如有其它问题，请及时联系客服人员。回0000拒收【双井13社区】';
			}
			break;
		case 'ytzwt':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码10分钟内有效。如非本人操作，请忽略本信息【月坛政务通】';
			}
			break;
		case 'sjall':
			{
				$result = $telnum.'回0000拒收【双井13社区】';
			}
			break;
		case 'rwdx':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码10分钟内有效。如非本人操作，请忽略本信息【任务大侠】';
			}
			break;
		case 'wzyz':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码10分钟内有效。如非本人操作，请忽略本信息【问政助手】';
			}
			break;
		case 'cyhelp':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码10分钟内有效。如非本人操作，请忽略本信息【朝阳公益储蓄中心】';
			}
			break;
		case 'dszst':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码10分钟内有效。如非本人操作，请忽略本信息【东四掌上通】';
			}
			break;
		case 'cwjdsbs':
			{
				$result = '手机验证码为：'.$telnum.'，感谢您进行手机绑定，该验证码10分钟内有效。如非本人操作，请忽略本信息【朝外街道社保所】';
			}
			break;
		case 'utmb':
			{
				$result = $telnum;
			}
			break;
		case 'mmd':
			{
				$result = '手机验证码为：'.$telnum.'，如非本人操作，请忽略本信息【摸摸哒】';
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
	echo '参数不全';exit;
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


/*开始加载短信服务内容*/
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
		echo '发送内容不能为空……';exit;
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
