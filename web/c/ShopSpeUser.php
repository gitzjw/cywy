<?php
final class ShopSpeUserController extends Base {
	
	public function getShopSpeUserWtype($wtype = '1',$city='') {
		$obj = new ShopSpeUserModel ();
		if($city){
			$w = 'wType="' . $wtype . '" and city="'.$city.'"';
		}else{
			$w = 'wType="' . $wtype . '"';
		}		
		$res = $obj->getShopSpeUser ( $w );
		return $res;
	}
	
	//专员Code查询商户 
	public function getShopSpeId($_sid=''){
		$obj = new CakeShopModel ();
		if ($_sid == '') {
			return false;
		} else {
			$w = ' shopInvCode="' . $_sid . '" ';
		}
		$res = $obj->getCakeShop ( $w, '', '', '' );
		return $res;
	}
	
	//用户ID查询操作记录详情
	public function getShopOrderHistoryUid($_uid){
		$obj = new ShopOrderHistoryModel ();
		$w = 'uId="' . $_uid . '"';
		$res = $obj->getShopOrderHistory ( $w,'','1','1' );
		return $res;
	}
	
	public function getShopSpeUserOpenId(){
		$obj = new ShopSpeUserModel();
		$parObj = new ParamsController();
		$openid = $parObj->getSessionParams('openid');
		$res = $obj->getShopSpeUser('openId="'.$openid.'"','','1','1');
		return $res;
	}
	
	public function addShopSpeUser() {
		$obj = new ShopSpeUserModel ();
		$user = $this->getUserDetail ();
		if (empty ( $user )) {
			$this->_jsonEn ( '601', '用户未注册' );
		}
		$_wType = Run::req ( 'wType' );
		$_sName = Run::req ( 'sName' );
		$_sTel = Run::req ( 'sTel' );
		$_sEmail = Run::req ( 'sEmail' );
		$_sCity = Run::req ( 'city' );
		
		if (! $_wType) {
			$this->_jsonEn ( '602', '请选择绑定类型' );
		}
		if (! $_sName) {
			$this->_jsonEn ( '602', '请输入姓名' );
		}
		if (! $_sTel) {
			$this->_jsonEn ( '602', '请输入电话' );
		}
		if (! $_sEmail) {
			$this->_jsonEn ( '602', '请输入邮箱' );
		}
		if (! $_sCity) {
			$this->_jsonEn ( '602', '请选择地区' );
		}
		
		$checkRes = $this->checkUid ( $user ['id'], $obj );
		if ($checkRes) {
			$this->_jsonEn ( '603', '已经绑定，请勿重复绑定' );
		}
		
		$dataArray ['uId'] = $user ['id'];
		$dataArray ['openid'] = $user ['openId'];
		$dataArray ['wType'] = $_wType;
		$dataArray ['sName'] = $_sName;
		$dataArray ['sTel'] = $_sTel;
		$dataArray ['sEmail'] = $_sEmail;
		$dataArray ['sStatus'] = '1';
		$dataArray ['city'] = $_sCity;
		$dataArray ['shopCode'] = $_sCity[0].$this->getRandomString(5);
		
		$res = $obj->addShopSpeUser ( $dataArray );
		if ($res) {
			$this->_jsonEn ( '1', '绑定成功' );
		} else {
			$this->_jsonEn ( '603', '绑定失败' );
		}
	}
	
	//核对是否已经注册
	public function checkUid($_uid = '', $obj) {
		$res = $obj->getShopSpeUser ( 'uId="' . $_uid . '"', '', '', '1' );
		if ($res) {
			return $res;
		} else {
			return false;
		}
	}
	
	public function getBdOrder($_uid){
		$obj = new ShopOrderAllotBdModel();		
		$res = $obj->getJoinShopOrder($_uid);
		return $res;
	}	

}