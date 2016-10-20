<?php
include_once '../../public/config.inc.php';
include_once '../../public/config.route.php';

final class WechatCallback {
	
	private $_req = null;
	private $_error = null;
	private $_resouce = null;
	
	public function WechatCallback() {
		$this->_req = $_REQUEST;
	}
	
	public function check() {
		if (! isset ( $this->_req ['code'] )) {
			$this->_error = '回调CODE出现错误';
			$this->error ();
		}
	}
	
	public function run() {
		$this->check ();
		$param = '?appid=wxbd92752eaebee0b5&secret=78188a2ad760a5095f1d07d77ab4df9b&code=' . $this->_req ['code'] . '&grant_type=authorization_code';
		$url = TOKEN_URL . $param;
		$res = Run::getHttpRes ( $url );
		$this->_resouce = json_decode ( $res, true );
		if (isset ( $this->_resouce ['errcode'] ) && $this->_resouce ['errcode'] == '40029') {
			$res = Run::getHttpRes ( $url );
			$this->_resouce = json_decode ( $res, true );
			if (isset ( $this->_resouce ['errcode'] ) && $this->_resouce ['errcode'] == '40029') {
				$this->_error = '微信服务器异常，请稍后重试！';
				$this->error ();
			}
		}
		$this->login ();
	}
	
	public function login() {
		Run::set_login_user ( $this->_resouce ['openid'] );
		$obj = new UsersController();
		$userDetail = $obj->getUsersOpenId($this->_resouce ['openid']);
		if (empty ( $userDetail )) {
			Run::show_msg ( '', '1', APP_WEBSITE . 'tmp.php?tpl=v1.shop.shop.mgs' );
		}else{
			Run::show_msg ( '', '1', APP_WEBSITE . 'tmp.php?tpl=v1.weihu' );
		}
		//$this->href ();
	}
	
	public function href() {
		if (is_array ( $this->_resouce )) {
			//执行跳转
			if(isset($this->_req['i'])){
				Run::show_msg ( '', '1', APP_WEBSITE . '' . $this->_req ['tpl'].'&i='.$this->_req['i'] );
			}else{
				Run::show_msg ( '', '1', APP_WEBSITE . '' . $this->_req ['tpl'] );
			}			
			exit ();
		} else {
			$this->_error = '获取用户资料错误,请先关注微信服务号';
			$this->error ();
		}
	}
	
	public function error() {
		echo $this->_error;
		exit ();
	}

}
$obj = new WechatCallback ();
$obj->run ();
?>