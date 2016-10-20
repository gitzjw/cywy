<?php
final class ShopVendorProEuiController extends Base {
	
	public function getShopVendorProList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopVendorProModel ();
		$ueObj->setField ( '*' );
		$w = $this->getWhere ();
		$res = $ueObj->getShopVendorPro ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopVendorPro ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_vid = Run::req ( '_vid' );
		$_pid = Run::req ( '_pid' );
		$_wtype = Run::req ( '_wtype' );
		$_wtypepid = Run::req ( '_wtypepid' );
		if (! $_wtype && ! $_pid && ! $_vid && ! $_wtypepid) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_vid) {
			$w .= ' and vId="' . $_vid . '" ';
		}
		if ($_pid) {
			$w .= ' and pId="' . $_pid . '" ';
		}
		if ($_wtype) {
			$w .= ' and wType="' . $_wtype . '" ';
		}
		if ($_wtypepid) {
			$w .= ' and wTypePid="' . $_wtypepid . '" ';
		}
		return $w;
	}
	
	private function getShopProDetail($id) {
		$obj = new ShopProModel ();
		$obj->setField('wType,title,id');
		$w = ' id="' . $id . '" ';
		$res = $obj->getShopPro ( $w, '', '1', '1' );
		return $res;
	}
	
	public function getShopProWtypeHtml() {
		$_name = Run::req('_name');
		$_name = $_name?$_name:'wType';
		$obj = new ShopProModel ();
		$obj->setField('wType,title,id');
		$wtype = Run::req('wType');
		$w = ' wType="' . $wtype . '" ';
		$res = $obj->getShopPro ( $w, 'aLif', '', '' );
		$_html = '<select name="' . $_name . '" style="width:165px;">';
		foreach ( $res as $ok => $ov ) {
			$_html .= "<option value='{$ov['id']}'>{$ov['title']}</option>";
		}
		$_html .= '</select>';
		echo $_html;
	}
	
	private function getShopVendorDetail($id) {
		$obj = new ShopVendorModel ();
		$w = ' id="' . $id . '" ';
		$res = $obj->getShopVendor ( $w, '', '1', '1' );
		return $res;
	}
	
	public function saveShopVendorPro() {
		$_id = Run::req ( 'id' );
		
		$_d ['vId'] = Run::req ( 'vId' );
		if (empty ( $_d ['vId'] )) {
			echo '请选择供应商';
			exit ();
		}
		$_d ['pId'] = Run::req ( 'pId' );
		if (empty ( $_d ['pId'] )) {
			echo '请选择供产品';
			exit ();
		}
		$_d ['price'] = Run::req ( 'price' );
		$_d ['pmark'] = Run::req ( 'pmark' );
		$spRes = $this->getShopProDetail ( $_d ['pId'] );
		$_d ['wTypePid'] = Run::req ('wTypePid');
		$_d ['wType'] = $spRes ['wType'];
		$_d ['pTitle'] = $spRes ['title'];
		$svRes = $this->getShopVendorDetail ( $_d ['vId'] );
		$_d ['vName'] = $svRes ['vName'];
		
		$sObj = D ( 'ShopVendorPro' );
		if ($_id) {
			$res = $sObj->setShopVendorPro ( $_id, $_d );
		} else {
			$res = $sObj->addShopVendorPro ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}

}