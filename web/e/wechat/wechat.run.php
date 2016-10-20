<?php
include_once '../../public/config.inc.php';
final class HrefClass {
	
	private $_req = null;
	private $_tpl = 'v1.index';
	private $_jumpUrl = 'http://web.chongyewuyou.com/e/wechat/wechat.callback.php?tpl=';
	
	public function HrefClass() {
		$this->_req = $_REQUEST;
		if (isset ( $_REQUEST ['tpl'] )) {
			$this->_tpl = $_REQUEST ['tpl'];
		}
		$this->_jumpUrl .= $this->_tpl;
	}
	
	public function run() {
		$URL = AUTH_URL . '?appid=' . APPID . '&redirect_uri=' . urlencode ( $this->_jumpUrl ) . '&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
		header ( "location:" . $URL );
	}
}
$hrefClass = new HrefClass ();
$hrefClass->run ();
exit ();
?>