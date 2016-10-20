<?php
final class ShopSpeUserEuiController extends Base {
	
	public function getShopSpeUserList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopSpeUserModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopSpeUser ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopSpeUser ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_idCard = Run::req ( '_idcard' );
		$_tel = Run::req ( '_tel' );
		$_id = Run::req ( '_id' );
		$_wtype = Run::req ( '_wtype' );
		if (! $_idCard && ! $_tel && ! $_id && ! $_wtype) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_idCard) {
			$w .= ' and sEmail="' . $_idCard . '" ';
		}
		if ($_tel) {
			$w .= ' and sTel="' . $_tel . '" ';
		}
		if ($_id) {
			$w .= ' and uId="' . $_id . '" ';
		}
		if ($_wtype) {
			$w .= ' and wType="' . $_wtype . '" ';
		}
		return $w;
	}
	
	public function getShopSpeUserCity() {
		$obj = new ShopSpeUserModel ();
		$_city = Run::req ( 'city' );
		$_wt = Run::req('wType');
		$obj->setField ( 'uId,sName' );
		$w = 'city="' . $_city . '" and wType="'.$_wt.'"';
		$res = $obj->getShopSpeUser ( $w );
		echo json_encode ( $res );
		exit ();
	}

}