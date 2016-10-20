<?php
final class InsPriceEuiController extends Base{
	
	public function getInsPriceList(){
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new InsPriceModel ();		
		$res = $ueObj->getInsPrice ( '', '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getInsPrice ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
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