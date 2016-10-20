<?php
final class SerMemberEuiController extends Base {
	
	public function getSerMemberList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$aeObj = new SerMemberModel ();
		$aeObj->setField ( ' *,(select sName from `website_type` w where w.id=wType) as wTypeName ' );
		$res = $aeObj->getSerMember ( '', '', $limit );
		$aeObj->setField ( 'count(id) as total' );
		$totalRes = $aeObj->getSerMember ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	public function getSerMemberComBox() {
		$obj = new WebTypeModel ();
		$w = ' parentId="2" ';
		$res = $obj->getWebType ( $w );
		$_a = array ();
		foreach ( $res as $k => $v ) {
			$_a [$k] ['wType'] = $v ['id'];
			$_a [$k] ['wTypeName'] = $v ['sName'];
		}
		echo json_encode ( $_a );
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
	
	public function getSerMemberAllSelect() {
		$obj = D ( 'SerMember' );
		$res = $obj->getSerMember ();
		$_name = Run::req ( 'name' );
		$_name = $_name ? $_name : 'smIdOne';
		$_html = '<select name="' . $_name . '">';
		foreach ( $res as $k => $v ) {
			$_html .= '<option value="' . $v ['id'] . '">' . $v ['sName'] . '</option>';
		}
		$_html .= '</select>';
		echo $_html;
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