<?php
final class ShopOrderHistoryModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrderHistory($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order_history` ';
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
	
	public function addShopOrderHistory($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['oId'] = $data ['oId'];
		$dataArray ['oStatus'] = $data ['oStatus'];
		$dataArray ['oUser'] = $data ['oUser'];
		$dataArray ['rUser'] = $data ['rUser'];
		$dataArray ['createTime'] = $data ['createTime'];
				
		$res = $this->insert ( 'shop_order_history', $dataArray );
		return $res;
	}
	
	public function setShopOrderHistory($id, $dataArray) {
		$res = $this->update ( 'shop_order_history', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrderHistory($id) {
		$res = $this->delete ( 'shop_order_history', ' id="' . $id . '" ' );
		return $res;
	}
}