<?php
final class RepairPriceController extends Base {
	
	public function getRepairPriceList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'RepairPrice' );
		$res = $obj->getRepairPrice ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getRepairPriceAllCount() {
		$obj = D ( 'RepairPrice' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getRepairPrice ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getRepairPriceId($_id) {
		$obj = D ( 'RepairPrice' );
		$res = $obj->getRepairPrice ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function getRepairPriceStatus($_s = '1') {
		$obj = D ( 'RepairPrice' );
		$res = $obj->getRepairPrice ( " rpStatus='{$_s}'", ' id ' );
		return $res;
	}
	
	public function getRepairPriceCity($city) {
		$obj = D ( 'RepairPrice' );
		$w = " rpCity='{$city}' and rpStatus='1'";
		$res = $obj->getRepairPrice ( $w );
		$_tmpRes = array ();
		foreach ( $res as $k => $v ) {
			$_tmpRes [$v ['wType']] = $v;
		}
		return $_tmpRes;
	}
	
	public function saveRepairPrice() {
		$_id = Run::req ( 'id' );
		
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['rpCity'] = Run::req ( 'rpCity' );
		$_d ['oPrice'] = Run::req ( 'oPrice' );
		$_d ['dPrice'] = Run::req ( 'dPrice' );
		$_d ['nPrice'] = intval ( $_d ['oPrice'] ) - intval ( $_d ['dPrice'] );
		$_d ['rpStatus'] = Run::req ( 'rpStatus' );
		
		$sObj = D ( 'RepairPrice' );
		if ($_id) {
			$res = $sObj->setRepairPrice ( $_id, $_d );
		} else {
			$res = $sObj->addRepairPrice ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=repair.price' );
		}
	}

}