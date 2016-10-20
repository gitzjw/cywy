<?php
final class ShopOrderExpressMoneyEuiController extends Base {
	
	public function getShopOrderExpressMoneyList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopOrderExpressMoneyModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopOrderExpressMoney ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopOrderExpressMoney ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_idCard = Run::req ( '_idcard' );
		$_tel = Run::req ( '_tel' );
		$_xm = Run::req ( '_xm' );
		if (! $_idCard && ! $_tel && ! $_xm) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_idCard) {
			$w .= ' and vEmail="' . $_idCard . '" ';
		}
		if ($_tel) {
			$w .= ' and vTel="' . $_tel . '" ';
		}
		if ($_xm) {
			$w .= ' and vName="' . $_xm . '" ';
		}
		return $w;
	}
		
	public function saveShopOrderExpressMoney() {
		$_id = Run::req ( 'id' );
		
		$_d ['money'] = Run::req ( 'money' );
		$_d ['exp_money'] = Run::req ( 'exp_money' );
		$_d ['city'] = Run::req ( 'city' );
		$_d ['exp_status'] = Run::req ( 'exp_status' );
		
		$sObj = new ShopOrderExpressMoneyModel();
		if ($_id) {
			$res = $sObj->setShopOrderExpressMoney ( $_id, $_d );
		} else {
			$res = $sObj->addShopOrderExpressMoney ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}

}