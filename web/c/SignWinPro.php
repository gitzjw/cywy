<?php
final class SignWinProController extends Base {
	
	public function getSignWinProList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'SignWinPro' );
		$res = $obj->getSignWinPro ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getSignWinProAllCount() {
		$obj = D ( 'SignWinPro' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignWinPro ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getSignWinProScidCdate($scid = '', $cdate = '') {
		if ($scid == '') {
			return false;
		}
		if ($cdate == '') {
			$date = date ( 'Y-m' );
		}
		$obj = D ( 'SignWinPro' );
		$res = $obj->getSignWinPro ( "cDate='{$date}' and scId='{$scid}' ", '', '1', '1' );
		return $res;
	}
	
	public function getSignWinProId($id = '') {
		$obj = D ( 'SignWinPro' );
		$res = $obj->getSignWinPro ( "id='{$id}'", '', '1', '1' );
		return $res;
	}
	
	public function getSignWinProDate($date = '') {
		if ($date == '') {
			$date = date ( 'Y-m' );
		}
		$obj = D ( 'SignWinPro' );
		$res = $obj->getSignWinPro ( " cDate='{$date}'", 'id' );
		if (! $res) {
			return array ();
		}
		return $res;
	}
	
	public function saveSignWinPro() {
		$_id = Run::req ( 'id' );
		
		$_d ['title'] = Run::req ( 'title' );
		$_d ['subTitle'] = Run::req ( 'subTitle' );
		$_d ['winMsg'] = Run::req ( 'winMsg' );
		$_d ['content'] = Run::req ( 'content' );
		$_d ['cDate'] = Run::req ( 'cDate' );
		$img = $this->uploadImg ( $_FILES ['upload'] );
		if ($img) {
			$_d ['imgPath'] = $img;
		} else {
			$_d ['imgPath'] = Run::req ( 'imgPath' );
		}
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['scId'] = Run::req ( 'scId' );
		$_d ['oMark'] = Run::req ( 'oMark' );
		
		$sObj = D ( 'SignWinPro' );
		if ($_id) {
			$res = $sObj->setSignWinPro ( $_id, $_d );
		} else {
			$res = $sObj->addSignWinPro ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=sign.win.pro' );
		}
	}
}