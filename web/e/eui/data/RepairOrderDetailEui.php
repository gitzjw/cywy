<?php
final class RepairOrderDetailEuiController extends Base {
	
	public function getRepairOrderDetailList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new RepairOrderDetailModel ();
		$w = $this->getWhere ();
		$ueObj->setField ( '*,(select sName from website_type w where w.id=wType) as wTypeName ' );
		$res = $ueObj->getRepairOrderDetail ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getRepairOrderDetail ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_id = Run::req ( '_id' );
		$_uid = Run::req ( '_uid' );
		$_oid = Run::req ( '_oid' );
		if (! $_id && ! $_uid && ! $_oid) {
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
		if ($_oid) {
			$w .= ' and oId="' . $_oid . '" ';
		}
		
		return $w;
	}
	
	public function getRepairOrderDetailAllCount() {
		$obj = D ( 'RepairOrderDetail' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getRepairOrderDetail ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getRepairOrderDetailOidList($oid = '', $lim = '') {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'RepairOrderDetail' );
		$w = ' oId="' . $oid . '" ';
		if ($lim != '') {
			$limit = '';
		}
		$res = $obj->getRepairOrderDetail ( $w, '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getRepairOrderDetailOidAllCount($oid = '') {
		$obj = D ( 'RepairOrderDetail' );
		$obj->setField ( ' count(id) as total ' );
		$w = ' oId="' . $oid . '" ';
		$res = $obj->getRepairOrderDetail ( $w, '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function updateRepairOrderDetailStatus($oid, $s) {
		$obj = new RepairOrderDetailModel ();
		$dataArray ['odStatus'] = $s;
		$res = $obj->setRepairOrderDetailOid ( $oid, $dataArray );
		return $res;
	}

}