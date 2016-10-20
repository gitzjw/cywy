<?php
final class SignDayConfigEuiController extends Base {
	
	public function getSignDayConfigList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$aeObj = new SignDayConfigModel ();
		$aeObj->setField ( '*,(select sName from website_type w where w.id=wType) as wTypeName' );
		$res = $aeObj->getSignDayConfig ( '', '', $limit );
		$aeObj->setField ( 'count(id) as total' );
		$totalRes = $aeObj->getSignDayConfig ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	public function getSignDayConfigSelect(){
		$obj = new SignDayConfigModel();
		$res = $obj->getSignDayConfig();
		$_name = Run::req ( 'name' );
		$_name = $_name ? $_name : 'scId';
		$_html = '<select name="' . $_name . '">';
		foreach ( $res as $k => $v ) {
			$_html .= '<option value="' . $v ['id'] . '">' . $v ['title'] . '</option>';
		}
		$_html .= '</select>';
		echo $_html;
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
			$_tmpDate = date('Y-m',strtotime("+1 months",strtotime($date)));
		}
		$obj = D ( 'SignDayConfig' );
		$w = " cDate='{$date}' or cDate='{$_tmpDate}' ";
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
		$_d ['cDate'] = date('Y-m',strtotime(Run::req ( 'cDate' )));
		$_d ['cDayNum'] = Run::req ( 'cDayNum' );
		$_d ['cSpeDate'] = Run::req ( 'cSpeDate' );
		$_d ['cSpeDate'] = $_d ['cSpeDate']?date('Y-m-d',strtotime($_d ['cSpeDate'])):'';
		
		$sObj = D ( 'SignDayConfig' );
		if ($_id) {
			$res = $sObj->setSignDayConfig ( $_id, $_d );
		} else {
			$res = $sObj->addSignDayConfig ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		}else{
			echo '操作失败';
		}
	}

}