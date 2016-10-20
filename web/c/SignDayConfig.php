<?php
final class SignDayConfigController extends Base {
	
	public function getSignDayConfigList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'SignDayConfig' );
		$res = $obj->getSignDayConfig ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getSignDayConfigAllCount() {
		$obj = D ( 'SignDayConfig' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignDayConfig ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getSignDayConfigAll() {
		$obj = D ( 'SignDayConfig' );
		$res = $obj->getSignDayConfig ();
		$newRes = array ();
		foreach ( $res as $k => $v ) {
			$newRes [$v ['id']] = $v;
		}
		return $newRes;
	}
	
	public function getSignDayConfigDate($date = '') {
		if ($date == '') {
			$date = date ( 'Y-m' );
			$_tmpDate = date('Y-m',strtotime("+1 months"));
		}else{
			$date = date ( 'Y-m' );
			$_tmpDate = date('Y-m',strtotime("+1 months",strtotime($date)));
		}
		$obj = D ( 'SignDayConfig' );
		$w = " cDate='{$date}' ";
		$res = $obj->getSignDayConfig ( $w );
		return $res;
	}
	
	public function getSignDayConfigId($id = '') {
		$obj = D ( 'SignDayConfig' );
		$res = $obj->getSignDayConfig ( "id='{$id}'", '', '1', '1' );
		return $res;
	}
	
	public function saveSignDayConfig() {
		$_id = Run::req ( 'id' );
		
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['title'] = Run::req ( 'title' );
		$_d ['cDate'] = Run::req ( 'cDate' );
		$_d ['cDayNum'] = Run::req ( 'cDayNum' );
		$_d ['cSpeDate'] = Run::req ( 'cSpeDate' );
		
		$sObj = D ( 'SignDayConfig' );
		if ($_id) {
			$res = $sObj->setSignDayConfig ( $_id, $_d );
		} else {
			$res = $sObj->addSignDayConfig ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=sign.dayconfig' );
		}
	}

}