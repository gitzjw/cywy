<?php
final class RepairOrderDetailController extends Base {
	
	public function getRepairOrderDetailList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'RepairOrderDetail' );
		$res = $obj->getRepairOrderDetail ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
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