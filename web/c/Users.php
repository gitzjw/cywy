<?php
final class UsersController extends Base {
	
	public function getUsersList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'Users' );
		$res = $obj->getUsers ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getUsersAllCount() {
		$obj = D ( 'Users' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getUsers ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
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
	
	//注册校验身份证是否存在 
	public function checkIdCard($idCard = '') {
		if (empty ( $idCard )) {
			return false;
		}
		$obj = D ( 'Users' );
		$res = $obj->getUsers ( ' idCard="' . $idCard . '" ', '', '', '1' );
		if (empty ( $res )) {
			return false;
		}
		return $res;
	}
	
	public function getUsersOpenId($oid = '') {
		if (empty ( $oid )) {
			return false;
		}
		$obj = D ( 'Users' );
		$res = $obj->getUsers ( ' openId="' . $oid . '" ', '', '', '1' );
		if (empty ( $res )) {
			return false;
		}
		return $res;
	}
	
	//登录
	public function loginUsers() {
		$obj = new ParamsController ();
		$oid = $obj->getSessionParams ( 'openid' );
		$res = $this->getUsersOpenId ( $oid );
		$obj->localSetParams ( 'userDetail', $res );
		return $res;
	}
	
	//注册
	public function regUsers() {
		$paramsObj = new ParamsController ();
		$idCard = Run::req ( 'idCard' );
		$telNumber = Run::req ( 'telNumber' );
		$rndStr = Run::req ( 'rndstr' );
		
		$res = $this->isIdCardNo ( $idCard );
		if (! $res) {
			echo '4';
			exit ();
		}
		
		$_s = $paramsObj->getSessionParams ( "VC_" . $telNumber );
		if (! $_s) {
			echo 0;
			exit ();
		}
		if ($rndStr != $_s) {
			echo 0;
			exit ();
		}
		
		$res = $this->saveUsers ();
		if ($res) {
			$lRes = $this->loginUsers ();
			if ($lRes) {
				$bRes = $this->bindingInsMember ( $idCard, $lRes ['id'] );
				if (! empty ( $bRes )) {
					$iRes = $this->bindingIns ( $bRes ['id'], $lRes ['id'] );
				}
				echo 1;
				exit ();
			} else {
				echo 3;
				exit ();
			}
		} else {
			echo 3;
			exit ();
		}
	}
	
	//二次绑定
	public function bindingOtherReg($users) {
		if (empty ( $users )) {
			return false;
		}
		$bRes = $this->bindingInsMember ( $users ['idCard'], $users ['id'] );
		if (! empty ( $bRes )) {
			$iRes = $this->bindingIns ( $bRes ['id'], $users ['id'] );
		} else {
			return false;
		}
		$obj = new InsController ();
		$res = $obj->getInsUsersId ( $users ['id'] );
		return $res;
	}
	
	//绑定保单人
	public function bindingInsMember($idcard = '', $userid = '') {
		if (empty ( $idcard )) {
			return false;
		}
		if (empty ( $userid )) {
			return false;
		}
		$obj = new InsMemberController ();
		$dRes = $obj->getInsMemberIdCard ( $idcard );
		if (empty ( $dRes )) {
			return false;
		}
		$dRes ['iUserId'] = $userid;
		$res = $obj->updateInsMember ( $dRes ['id'], $dRes );
		return $dRes;
	}
	
	//绑定保险单
	public function bindingIns($insMemberId = '', $userid = '') {
		if (empty ( $insMemberId )) {
			return false;
		}
		if (empty ( $userid )) {
			return false;
		}
		$obj = new InsController ();
		$res = $obj->getInsInsuerId ( $insMemberId );
		if (empty ( $res )) {
			return false;
		}
		$res ['iUserId'] = $userid;
		$res = $obj->updateIns ( $res ['id'], $res );
		return $res;
	}
	
	//发送验证码
	public function sendRndStr() {
		$paramsObj = new ParamsController ();
		$user = $paramsObj->getSessionParams ( 'userDetail' );
		$data ['version'] = "1.0.0";
		$data ['telnum'] = Run::req ( 'telnum' );
		$_rndStr = $this->getRandomString ();
		$info = '手机验证码为：' . $_rndStr . '，如非本人操作，请忽略本信息【宠业无忧】';
		$mgsRes = Run::sendMessage ( $data ['telnum'], $info );
		if ($mgsRes == '00') {
			$paramsObj->localSetParams ( "VC_" . $data ['telnum'], $_rndStr );
			//			echo $res ['content'];
			echo 1;
		} else {
			echo 0;
		}
		exit ();
	}
	
	public function saveUsers() {
		$_id = Run::req ( 'id' );
		
		$_d ['idCard'] = Run::req ( 'idCard' );
		$_d ['telNumber'] = Run::req ( 'telNumber' );
		$_d ['openId'] = Run::req ( 'openId' );
		$_d ['uType'] = Run::req ( 'uType' );
		$_d ['uPwd'] = Run::req ( 'uPwd' );
		$_d ['uCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['uStatus'] = Run::req ( 'uStatus' );
		
		if (empty ( $_d ['openId'] )) {
			return false;
		}
		
		$cRes = $this->checkTel ( $_d ['telNumber'] );
		if ($cRes) {
			return false;
		}
		$cRes = $this->checkIdCard ( $_d ['idCard'] );
		if ($cRes) {
			return false;
		}
		
		$sObj = D ( 'Users' );
		if ($_id) {
			$res = $sObj->setUsers ( $_id, $_d );
		} else {
			$_d ['id'] = $this->Sysid ();
			$res = $sObj->addUsers ( $_d );
		}
		
		if ($res) {
			return $res;
		} else {
			return false;
		}
	}
	
	//校验手机号是否存在，如果已经存在，则进行更新openid
	public function checkNewOpenId(){
		$_tel = Run::req('_tel');
		
		$res = $this->checkTel($_tel);
		if($res){
			//已经存在，进行同步更新openid
			$paramsObj = new ParamsController ();
			$obj = new UsersModel();
			$res['openId'] = $paramsObj->getSessionParams('openid');
			$res['uCreateDate'] = date('Y-m-d H:i:s');
			$result = $obj->setUsers($res['id'], $res);
			if($result){
				$this->loginUsers();
				$this->_jsonEn('1','恭喜您，账号同步成功，全新平台【宠业无忧】为您提供更全面的服务。');
			}else{
				$this->_jsonEn('102','账号同步失败');
			}
		}else{
			$this->_jsonEn('103','非萌工社原用户，请进行注册');
		}
	}

}