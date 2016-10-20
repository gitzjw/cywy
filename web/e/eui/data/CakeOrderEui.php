<?php
final class CakeOrderEuiController extends Base {
	
	public function getCakeOrderList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new CakeOrderModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getCakeOrder ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getCakeOrder ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_name = Run::req ( '_name' );
		$_tel = Run::req ( '_tel' );
		$_pet = Run::req ( '_pet' );
		$_bir = Run::req ( '_bir' );
		if (! $_name && ! $_tel && ! $_pet && ! $_bir) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_name) {
			$w .= ' and oName="' . $_name . '" ';
		}
		if ($_tel) {
			$w .= ' and soTel="' . $_tel . '" ';
		}
		if ($_pet) {
			$w .= ' and petName="' . $_pet . '" ';
		}
		if ($_bir) {
			$w .= ' and petBirthday="' . $_bir . '" ';
		}
		return $w;
	}
	
	public function updateStatus() {
		$_s = Run::req ( '_s' );
		$_id = Run::req ( '_id' );
		$_msg = Run::req ( '_msg' );
		$_u = $_SESSION [APP_NAME . '_admin_'] ['uName'];
		$obj = new CakeOrderModel ();
		$data ['status'] = $_s;
		$data ['oMsg'] = $_msg;
		$data ['oUser'] = $_u;
		$res = $obj->setCakeOrder ( $_id, $data );
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
}