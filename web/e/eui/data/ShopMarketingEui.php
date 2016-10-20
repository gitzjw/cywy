<?php
final class ShopMarketingEuiController extends Base {
	
	public function getShopMarketingList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopMarketingModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopMarketing ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopMarketing ( $w, '', '', '1' );
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
	
	public function getCitySelectHtml(){
		$a = Run::getCityCode('','');
		$_html  ='<select name="city">';
		foreach ($a as $k=>$v){
			$_html.="<option value='{$k}'>{$v}</option>";
		}
		$_html .='</select>';
		echo $_html;
	}
		
	public function saveShopMarketing() {
		$_id = Run::req ( 'id' );
		
		$_d ['sTime'] = Run::req ( 'sTime' );
		if ($_d ['sTime'] == '') {
			echo '请输入开始日期';
			exit ();
		}
		$_d ['eTime'] = Run::req ( 'eTime' );
		if ($_d ['eTime'] == '') {
			echo '请输入结束日期';
			exit ();
		}
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['money'] = Run::req ( 'money' );
		$_d ['nMoney'] = Run::req ( 'nMoney' );
		$_d ['pro'] = Run::req ( 'pro' );
		$_d ['city'] = Run::req ( 'city' );
		$_d ['oMark'] = Run::req ( 'oMark' );
		
		$sObj = D ( 'ShopMarketing' );
		if ($_id) {
			$res = $sObj->setShopMarketing ( $_id, $_d );
		} else {
			$res = $sObj->addShopMarketing ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}

}