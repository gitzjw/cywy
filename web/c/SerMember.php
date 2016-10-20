<?php
final class SerMemberController extends Base {
	
	public function getSerMemberList() {
		$_p = Run::req ( 'page' );
		$_page = intval ( $_p ) * 10;
		$limit = $_page . ',10';
		$obj = D ( 'SerMember' );
		$res = $obj->getSerMember ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getSerMemberAll() {
		$obj = D ( 'SerMember' );
		$res = $obj->getSerMember ();
		$newRes = array ();
		foreach ( $res as $k => $v ) {
			$newRes [$v ['id']] = $v;
		}
		return $newRes;
	}
	
	public function getSerMemberId($_id) {
		$obj = D ( 'SerMember' );
		$res = $obj->getSerMember ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function saveSerMember() {
		$_id = Run::req ( 'id' );
		
		$_d ['sName'] = Run::req ( 'sName' );
		$_d ['sTelNumber'] = Run::req ( 'sTelNumber' );
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['sStatus'] = Run::req ( 'sStatus' );
		
		$sObj = D ( 'SerMember' );
		if ($_id) {
			$res = $sObj->setSerMember ( $_id, $_d );
		} else {
			$res = $sObj->addSerMember ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=service.member' );
		}
	}

}