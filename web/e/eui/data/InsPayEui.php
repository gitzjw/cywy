<?php
final class InsPayEuiController extends Base {
	
	public function getInsPayList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new InsPayModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getInsPay ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getInsPay ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_id = Run::req ( '_id' );
		$_uid = Run::req ( '_uid' );
		$_payid = Run::req ( '_payid' );
		$_date = Run::req ( '_date' );
		
		if (! $_id && ! $_uid && ! $_payid && ! $_date) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_id) {
			$w .= ' and id="' . $_id . '" ';
		}
		if ($_uid) {
			$w .= ' and uId="' . $_uid . '" ';
		}
		if ($_payid) {
			$w .= ' and rPayCode="' . $_payid . '" ';
		}
		if ($_date) {
			$_date_time = strtotime ( $_date );
			$_date = date ( 'Y-m-d', $_date_time );
			$_date_n = date ( 'Y-m-d', strtotime ( "+1 day", $_date_time ) );
			$w .= ' and rPayTime>="' . $_date . '" and rPayTime<="' . $_date_n . '"';
		}
		
		return $w;
	}
	
	public function getInsPayDate($_date) {
		$obj = D ( 'InsPay' );
		$_s = $_date . ' 00:00:00';
		$_e_s = $_date . ' 23:59:59';
		$res = $obj->getInsPay ( " rPayTime>='{$_s}' and rPayTime<='{$_e_s}' " );
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