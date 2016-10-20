<?php
final class ShopOrderExpressMoneyModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrderExpressMoney($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order_express_money` ';
		if (! empty ( $where )) {
			$sql .= ' where ' . $where;
		}
		if (! empty ( $orderby )) {
			$sql .= ' order by ' . $orderby;
		} else {
			$sql .= ' order by id desc ';
		}
		if (! empty ( $limit )) {
			$sql .= ' limit ' . $limit;
		}
		
		if (empty ( $solo )) {
			$res = $this->get_all ( $sql );
		} else {
			$res = $this->get_one ( $sql );
		}
		return $res;
	}
	
	public function addShopOrderExpressMoney($data) {
		
		$dataArray ['money'] = $data ['money'];
		$dataArray ['city'] = $data ['city'];
		$dataArray ['exp_money'] = $data ['exp_money'];
		$dataArray ['exp_status'] = $data ['exp_status'];
		
		$res = $this->insert ( 'shop_order_express_money', $dataArray );
		return $res;
	}
	
	public function setShopOrderExpressMoney($id, $dataArray) {
		$res = $this->update ( 'shop_order_express_money', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrderExpressMoney($id) {
		$res = $this->delete ( 'shop_order_express_money', ' id="' . $id . '" ' );
		return $res;
	}
}