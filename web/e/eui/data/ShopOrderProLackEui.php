<?php
final class ShopOrderProLackEuiController extends Base {
	
	public function getShopOrderProLackList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopOrderProLackModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopOrderProLack ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopOrderProLack ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_sptm = Run::req ( '_sptm' );
		$_title = Run::req ( '_title' );
		$_uid = Run::req ( '_uid' );
		$_city = Run::req ( '_city' );
		
		if (! $_sptm && ! $_title && ! $_uid && ! $_city) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_sptm) {
			$w .= ' and sptm="' . $_sptm . '" ';
		}
		if ($_title) {
			$w .= ' and pTitle like "%' . $_title . '%" ';
		}
		if ($_uid) {
			$w .= ' and uId="' . $_uid . '" ';
		}
		if ($_city) {
			$w .= ' and city="' . $_city . '" ';
		}
		
		return $w;
	}
	
}