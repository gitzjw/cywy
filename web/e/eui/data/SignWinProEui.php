<?php
final class SignWinProEuiController extends Base {
	
	public function getSignWinProList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$aeObj = new SignWinProModel ();
		$aeObj->setField ( '*,(select sName from website_type w where w.id=wType) as wTypeName,(select title from sign_day_config sdc where sdc.id=scId) as scName ' );
		$res = $aeObj->getSignWinPro ( '', '', $limit );
		$aeObj->setField ( 'count(id) as total' );
		$totalRes = $aeObj->getSignWinPro ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
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
		$_d ['cDate'] = date ( 'Y-m', strtotime ( Run::req ( 'cDate' ) ) );
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
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
}