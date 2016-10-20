<?php
final class InsPriceController extends Base{
	
	public function getInsPriceList(){
		$_p = Run::req ( 'page' );
		$_page = intval ( $_p ) * 10;
		$limit = $_page . ',10';
		$obj = D('InsPrice');
		$res = $obj->getInsPrice ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getInsPriceId($_id){
		$obj = D ( 'InsPrice' );
		$res = $obj->getInsPrice ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsPriceStatus($_s='1'){
		$obj = D ( 'InsPrice' );
		$res = $obj->getInsPrice ( " pStatus='{$_s}'", ' id ');
		return $res;
	}
	
	public function saveInsPrice(){
		$_id = Run::req ( 'id' );
		
		$_d ['pSpan'] = Run::req ( 'pSpan' );
		$_d ['pDis'] = Run::req ( 'pDis' );
		$_d ['pPrice'] = Run::req ( 'pPrice' );
		$_d ['pNPrice'] = intval($_d ['pPrice'])-intval($_d ['pDis']);
		$_d ['pStatus'] = Run::req ( 'pStatus' );
				
		$sObj = D ( 'InsPrice' );
		if ($_id) {
			$res = $sObj->setInsPrice ( $_id, $_d );
		} else {
			$res = $sObj->addInsPrice ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=insurance.price' );
		}
	}
	
}