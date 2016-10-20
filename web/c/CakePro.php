<?php
final class CakeProController extends Base {
	
	//首页商品列表
	public function getCakeMainPro() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page_prev = intval ( $_p ) * 10;
		$limit = $_page_prev . ',' . 10;
		
		$obj = new CakeProModel ();
		$obj->setField ( 'id,title,listImgPath,oPrice,dPrice,nPrice' );
		$res = $obj->getCakePro ( ' status="1" ', ' isTop DESC,id DESC ', $limit );
		if ($res) {
			$this->_jsonEn ( '0', $res );
		} else {
			$this->_jsonEn ( '311', '暂无更多商品' );
		}
	}
	
	//查询单个商品
	public function getCakeProDetail($_id = '') {
		if ($_id == '') {
			$_id = Run::req ( 'i' );
		}
		$obj = new CakeProModel ();
		$res = $obj->getCakePro ( ' id="' . $_id . '" ', '', '', '1' );
		if ($res) {
			return $res;
		} else {
			if ($_id == '') {
				Run::show_msg ( '暂无该商品' );
			} else {
				return false;
			}
		}
	}

}