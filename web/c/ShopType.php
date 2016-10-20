<?php
final class ShopTypeController extends Base {
	
	public function getShopTypeParent() {
		$shopObj = new CakeShopController();
		$_shopRes = $shopObj->getCakeShopUid(1);
		
		if(!isset($_shopRes['city']) || empty($_shopRes['city'])){
			$shopObj = new ShopSpeUserController();
			$_shopRes = $shopObj->getShopSpeUserOpenId();
		}
		
		$obj = new ShopTypeModel ();
		$_index = Run::req ( '_index' );
		$_pid = Run::req ( '_pid' );
		$_pid = empty ( $_pid ) ? '0' : $_pid;
		$w = ' parentId="' . $_pid . '"  and cStatus="1" and city like "%'.$_shopRes['city'].'%" ';
		
		if ($_index == '1') {
			$w .= 'and isIndex="1"';
		}
		
		$res = $obj->getShopType ( $w, ' isTop desc,cSort desc' );
		$this->_jsonEn ( '1', $res );
	}

}