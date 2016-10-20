<?php
final class ShopOrderAllotBdEuiController extends Base {
	
	public function getShopOrderAllotBdList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopOrderAllotBdModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopOrderAllotBd ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopOrderAllotBd ( $w, '', '', '1' );
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
	
	public function saveShopOrderAllotBd() {
		
		$_d ['bdName'] = Run::req ( 'bdName' );
		$_d ['bdCity'] = Run::req ( 'bdCity' );
		$_d ['oId'] = Run::req ( 'oId' );
		$_d ['bdUid'] = Run::req ( 'bdUid' );
		
		if (empty ( $_d ['bdUid'] )) {
			echo '操作失败，请选择BD人员';
			exit ();
		}
		
		$w = 'oId="' . $_d ['oId'] . '"';
		
		$sObj = new ShopOrderAllotBdModel ();
		$_res = $sObj->getShopOrderAllotBd ( $w, '', '', '1', '1' );
		if (empty ( $_res )) {
			$res = $sObj->addShopOrderAllotBd ( $_d );
			echo '操作成功';
			exit ();
		}else{
			echo '操作失败，该订单已经分配';
			exit ();
		}
	}

}