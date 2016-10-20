<?php
final class CakeShopController extends Base {
	
	//uId查询商店
	public function getCakeShopUid($_s = '') {
		$users = $this->getUserDetail ();
		$_uid = $users ['id'];
		$obj = new CakeShopModel ();
		if ($_s == '') {
			$w = ' uId="' . $_uid . '" and status="2" ';
		} else {
			$w = ' uId="' . $_uid . '" ';
		}
		$res = $obj->getCakeShop ( $w, '', '', '1' );
		return $res;
	}
	
	//默认注册 
	public function defaultReg() {
		$obj = new ParamsController ();
		$_d ['idCard'] = '';
		$_d ['telNumber'] = Run::req ( 'shopTel' );
		$_d ['openId'] = $obj->getSessionParams ( 'openid' );
		$_d ['uType'] = '1';
		$_d ['uPwd'] = '';
		$_d ['uCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['uStatus'] = '1';
		
		if (empty ( $_d ['openId'] )) {
			$this->_jsonEn ( '304', '未授权' );
		}
		if(strlen($_d['telNumber'])!='11'){
			$this->_jsonEn ( '304', '联系电话输入错误' );
		}
		
		$cRes = $this->checkTel ( $_d ['telNumber'] );
		if ($cRes) {
			return $cRes;
		}
		
		$sObj = D ( 'Users' );
		$_d ['id'] = $this->Sysid ();
		$res = $sObj->addUsers ( $_d );
		
		if ($res) {
			return $_d;
		} else {
			return false;
		}
	}
	
	//注册校验手机是否存在 
	public function checkTel($tel = '') {
		if (empty ( $tel )) {
			return false;
		}
		$obj = D ( 'Users' );
		$res = $obj->getUsers ( ' telNumber="' . $tel . '" ', '', '', '1' );
		if (empty ( $res )) {
			return false;
		}
		return $res;
	}
	
	//申请成为蛋糕商店
	public function applyCakeShop() {
		$isShop = $this->getCakeShopUid ( 1 );
		if ($isShop) {
			$this->_jsonEn ( '301', '请勿重复申请' );
		}
		$users = $this->getUserDetail ();
		if (empty ( $users )) {
			//$this->_jsonEn ( '302', '未登录' );
			//进行默认注册
			$users = $this->defaultReg ();
			if (! $users) {
				$this->_jsonEn ( '302', '注册失败' );
			}
		}
		
		$_d ['uId'] = $users ['id'];
		$_d ['shopMainName'] = Run::req ( 'shopMainName' );
		if (empty ( $_d ['shopMainName'] )) {
			$this->_jsonEn ( '304', '请输入店主姓名' );
		}
		$_d ['shopName'] = Run::req ( 'shopName' );
		if (empty ( $_d ['shopName'] )) {
			$this->_jsonEn ( '304', '请输入店名' );
		}
		$_d ['shopAddress'] = Run::req ( 'shopAddress' );
		if (empty ( $_d ['shopAddress'] )) {
			$this->_jsonEn ( '304', '请输入地址' );
		}
		$_d ['shopTel'] = Run::req ( 'shopTel' );
		if (empty ( $_d ['shopTel'] )) {
			$this->_jsonEn ( '304', '请输入电话' );
		}
		if (strlen ( $_d ['shopTel'] )!='11') {
			$this->_jsonEn ( '304', '联系电话输入错误' );
		}
		$_d ['city'] = Run::req ( 'city' );
		if (empty ( $_d ['city'] )) {
			$this->_jsonEn ( '304', '请选择地区' );
		}
		$_d ['createTime'] = date ( 'Y-m-d H:i:s' );
		$_d ['status'] = '1';
		$obj = new CakeShopModel ();
		$res = $obj->addCakeShop ( $_d );
		if ($res) {			
			$this->_jsonEn ( '1', '申请成功，请待客服审核' );
		} else {
			$this->_jsonEn ( '303', '申请失败' );
		}
	}
	
	//申请成为采购商家
	public function applyShopShop() {
		$isShop = $this->getCakeShopUid ( 1 );
		if ($isShop) {
			if ($isShop ['shopInvCode'] != '') {
				$this->_jsonEn ( '301', '请勿重复申请' );
			} else {
				$this->updateShopShop ( $isShop );
			}
		}
		$users = $this->getUserDetail ();
		if (empty ( $users )) {
			//$this->_jsonEn ( '302', '未登录' );
			//进行默认注册
			$users = $this->defaultReg ();
			if (! $users) {
				$this->_jsonEn ( '302', '注册失败' );
			}
		}
		
		$_d ['uId'] = $users ['id'];
		$_d ['shopMainName'] = Run::req ( 'shopMainName' );
		if (empty ( $_d ['shopMainName'] )) {
			$this->_jsonEn ( '304', '请输入店主姓名' );
		}
		$_d ['shopName'] = Run::req ( 'shopName' );
		if (empty ( $_d ['shopName'] )) {
			$this->_jsonEn ( '304', '请输入店名' );
		}
		$_d ['shopAddress'] = Run::req ( 'shopAddress' );
		if (empty ( $_d ['shopAddress'] )) {
			$this->_jsonEn ( '304', '请输入地址' );
		}
		$_d ['shopTel'] = Run::req ( 'shopTel' );
		if (empty ( $_d ['shopTel'] )) {
			$this->_jsonEn ( '304', '请输入电话' );
		}
		if (strlen ( $_d ['shopTel'] )!='11') {
			$this->_jsonEn ( '304', '联系电话输入错误' );
		}
		$_d ['shopInvCode'] = Run::req ( 'shopInviteCode' );
		if (empty ( $_d ['shopInvCode'] )) {
			$this->_jsonEn ( '304', '请输入邀请码' );
		}
		$_d ['city'] = Run::req ( 'city' );
		if (empty ( $_d ['city'] )) {
			$this->_jsonEn ( '304', '请选择地区' );
		}
		
		$codeRes = $this->checkInvCode ( $_d ['shopInvCode'] );
		
		$_d ['createTime'] = date ( 'Y-m-d H:i:s' );
		$_d ['status'] = '1';
		$obj = new CakeShopModel ();
		$res = $obj->addCakeShop ( $_d );
		if ($res) {
			//更新邀请码
			//$this->updateInvCode($codeRes['id']);
			$this->_jsonEn ( '1', '申请成功，请待客服审核' );
		} else {
			$this->_jsonEn ( '303', '申请失败' );
		}
	}
	
	public function updateShopShop($shop) {
		
		$shop ['shopInvCode'] = Run::req ( 'shopInviteCode' );
		if (empty ( $shop ['shopInvCode'] )) {
			$this->_jsonEn ( '304', '请输入邀请码' );
		}
		$codeRes = $this->checkInvCode ( $shop ['shopInvCode'] );
		
		$obj = new CakeShopModel ();
		$res = $obj->setCakeShop ( $shop ['id'], $shop );
		if ($res) {
			//更新邀请码
			$this->updateInvCode($codeRes['id']);
			$this->_jsonEn ( '1', '绑定成功' );
		} else {
			$this->_jsonEn ( '303', '绑定失败' );
		}
	}
	
	//检查邀请码
	public function checkInvCode($_code) {
		/*$obj = new ShopInvCodeModel ();
		$res = $obj->getShopInvCode ( 'codeNum="' . $_code . '" and codeStatus="1"', '', '1', '1' );
		if (empty ( $res )) {
			$this->_jsonEn ( '304', '邀请码不存在或者已经被使用' );
		}		
		return $res;*/
		$obj = new CakeShopModel();
		$res = $obj->getCakeShop('shopInvCode="' . $_code . '"', '', '1', '1');
		if (!empty ( $res )) {
			return $res;
		}else{
			$this->_jsonEn ( '304', '邀请码填写错误，请联系商务经理进行核验。' );
		}		
	}
	
	public function updateInvCode($id) {
		$obj = new ShopInvCodeModel ();
		$_d ['codeStatus'] = '2';
		$res = $obj->setShopInvCode ( $id, $_d );
		return $res;
	}
	
	public function getCakeShopDetail($_id) {
		$obj = new CakeShopModel ();
		$res = $obj->getCakeShop ( 'id="' . $_id . '"', '', '1', '1' );
		return $res;
	}
	
	public function updateStatus() {
		$_s = Run::req ( '_s' );
		$_id = Run::req ( '_id' );
		$obj = new CakeShopModel ();
		$data ['status'] = $_s;
		$res = $obj->setCakeShop ( $_id, $data );
		if ($res) {
			if ($_s == "2") {
				$info = '【宠业无忧】恭喜您，商家身份绑定审核通过，如有问题请咨询4007-007-150，回N退订';
				$shopRes = $this->getCakeShopDetail ( $_id );
				$mgsRes = Run::sendMessage ( trim ( $shopRes ['shopTel'] ), $info, '0' );
			}
			echo '已经通过成功';
		} else {
			echo '操作失败';
		}
		exit();
	}
	
	public function saveCakeShop() {
		$_id = Run::req ( 'id' );
		if (empty ( $_id )) {
			echo '操作失败';
			exit ();
		}
		
		$obj = new CakeShopModel ();
		$res = $obj->getCakeShop ( 'id="' . $_id . '"', '', '1', '1' );
		if (empty ( $res )) {
			echo '操作失败，没有查询到数据';
			exit ();
		} else {
			$_d ['shopAddress'] = Run::req ('shopAddress');
			$_d ['shopTel'] = Run::req ('shopTel');
			$_d ['shopMainName'] = Run::req ('shopMainName');
			$_d ['shopName'] = Run::req ('shopName');
			$_d ['city'] = Run::req ('city');
			$_d ['shopInvCode'] = Run::req ('shopInvCode');
			
			$obj->setCakeShop ( $_id, $_d );
			echo '操作成功';
			exit ();
		}
	}

}