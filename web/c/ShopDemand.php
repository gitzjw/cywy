<?php
final class ShopDemandController extends Base {
	
	public function saveShopDemand() {
		$_id = Run::req ( 'id' );
		
		$_d ['content'] = Run::req ( 'content' );
		if (empty ( $_d ['content'] )) {
			$this->_jsonEn ( '702', '内容不能为空' );
		}
		$_d ['tel'] = Run::req ( 'tel' );
		if (empty ( $_d ['tel'] )) {
			$this->_jsonEn ( '702', '联系方式不能为空' );
		}
		$_d ['createTime'] = date ( 'Y-m-d H:i:s' );
		
		$sObj = new ShopDemandModel ();
		if ($_id) {
			$res = $sObj->setShopDemand ( $_id, $_d );
		} else {
			$res = $sObj->addShopDemand ( $_d );
		}
		
		if ($res) {
			$this->_jsonEn ( '1', '提交成功，我们将即时进行反馈' );
		} else {
			$this->_jsonEn ( '701', '提交失败' );
		}
	}

}