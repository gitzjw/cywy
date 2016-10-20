<?php
final class ShopOrderExpressModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrderExpress($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order_express` ';
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
	
	public function addShopOrderExpress($data) {
		
		$dataArray ['oId'] = $data ['oId'];
		$dataArray ['expId'] = $data ['expId'];
		$dataArray ['expName'] = $data ['expName'];
		
		$res = $this->insert ( 'shop_order_express', $dataArray );
		return $res;
	}
	
	public function setShopOrderExpress($id, $dataArray) {
		$res = $this->update ( 'shop_order_express', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrderExpress($id) {
		$res = $this->delete ( 'shop_order_express', ' id="' . $id . '" ' );
		return $res;
	}
}