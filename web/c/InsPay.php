<?php
final class InsPayController extends Base {
	
	public function getInsPayList() {
		$_p = Run::req ( 'page' );
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'InsPay' );
		$res = $obj->getInsPay ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getInsPayDate($_date) {
		$obj = D ( 'InsPay' );
		$_s = $_date.' 00:00:00';
		$_e_s = $_date.' 23:59:59';
		$res = $obj->getInsPay ( " rPayTime>='{$_s}' and rPayTime<='{$_e_s}' ");
		return $res;
	}
	
	public function getInsPayAllCount() {
		$obj = D ( 'InsPay' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getInsPay ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getInsPayId($_id) {
		$obj = D ( 'InsPay' );
		$res = $obj->getInsPay ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsPayUserId($_uid) {
		$obj = D ( 'InsPay' );
		$res = $obj->getInsPay ( "uId='{$_uid}'" );
		return $res;
	}
	
	public function saveInsPay($data) {
		$_id = isset ( $data ['id'] ) ? $data ['id'] : '';
		
		$_d ['rPay'] = $data ['rPay'];
		$_d ['rPayCode'] = $data ['rPayCode'];
		$_d ['rPayTime'] = $data ['rPayTime'];
		$_d ['rCreateTime'] = $data ['rCreateTime'];
		$_d ['rSpan'] = $data ['rSpan'];
		$_d ['rStatus'] = $data ['rStatus'];
		$_d ['uId'] = $data ['uId'];
		
		$sObj = D ( 'InsPay' );
		if ($_id) {
			$res = $sObj->setInsPay ( $_id, $_d );
			$_d ['id'] = $_id;
		} else {
			$_d ['id'] = $this->SysOrderId ();
			$_d ['rCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
			$res = $sObj->addInsPay ( $_d );
		}
		
		if ($res) {
			return $_d;
		} else {
			return false;
		}
	}

}