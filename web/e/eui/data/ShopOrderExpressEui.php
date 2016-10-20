<?php
final class ShopOrderExpressEuiController extends Base {
	
	public function getShopOrderExpressList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopOrderExpressModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopOrderExpress ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopOrderExpress ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_oid = Run::req ( '_oid' );
		$_wlmc = Run::req ( '_wlmc' );
		
		if (! $_oid && ! $_wlmc) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_oid) {
			$w .= ' and oId="' . $_oid . '" ';
		}
		if ($_wlmc) {
			$w .= ' and expName like "%' . $_wlmc . '%" ';
		}
		
		return $w;
	}
	
	public function getShopOrderLogTxt(){
		$_f = file_get_contents(APP_PATH . 'public/log/third_send_goods.log');
		$_f = str_replace("\n", "<br/>", $_f);
		echo $_f;
		exit;
	}

}