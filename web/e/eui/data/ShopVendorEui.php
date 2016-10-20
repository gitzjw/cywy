<?php
final class ShopVendorEuiController extends Base {
	
	public function getShopVendorList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopVendorModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopVendor ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopVendor ( $w, '', '', '1' );
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
	
	public function getShopVendorSelectHtml(){
		$_name = Run::req('_name');
		$_name = $_name?$_name:'vId';
		
		$obj = new ShopVendorModel();
		$data = $obj->getShopVendor();
		
		$_html = '<select name="' . $_name . '">';
		foreach ( $data as $ok => $ov ) {
			$_html .= "<option value='{$ov['id']}'>{$ov['vName']}</option>";
		}
		$_html .= '</select>';
		echo $_html;
	}
	
	public function saveShopVendor() {
		$_id = Run::req ( 'id' );
		
		$_d ['vName'] = Run::req ( 'vName' );
		if ($_d ['vName'] == '') {
			echo '请输入姓名';
			exit ();
		}
		$_d ['vTel'] = Run::req ( 'vTel' );
		if ($_d ['vTel'] == '') {
			echo '请输入联系电话';
			exit ();
		}
		$_d ['vAddress'] = Run::req ( 'vAddress' );
		$_d ['vEmail'] = Run::req ( 'vEmail' );
		$_d ['vStatus'] = Run::req ( 'vStatus' );
		
		$sObj = D ( 'ShopVendor' );
		if ($_id) {
			$res = $sObj->setShopVendor ( $_id, $_d );
		} else {
			$res = $sObj->addShopVendor ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}

}