<?php
final class RepairOrderHistoryController extends Base {
	
	public function getRepairOrderHistoryList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'RepairOrderHistory' );
		$res = $obj->getRepairOrderHistory ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getRepairOrderHistoryAllCount() {
		$obj = D ( 'RepairOrderHistory' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getRepairOrderHistory ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getRepairOrderHistoryOid($oid) {
		$obj = D ( 'RepairOrderHistory' );
		$res = $obj->getRepairOrderHistory ( "oId='{$oid}'", '', '', '' );
		return $res;
	}

}