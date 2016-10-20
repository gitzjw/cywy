<?php
final class ShopOrderDetailModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrderDetail($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order_detail` ';
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
	
	public function addShopOrderDetail($data) {
		
		$dataArray ['oId'] = $data ['oId'];
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['pId'] = $data ['pId'];
		$dataArray ['pTitle'] = $data ['pTitle'];
		$dataArray ['eNum'] = $data ['eNum'];
		$dataArray ['ePrice'] = $data ['ePrice'];
		$dataArray ['tPrice'] = $data ['tPrice'];
		$dataArray ['odStatus'] = $data ['odStatus'];
		
		$res = $this->insert ( 'shop_order_detail', $dataArray );
		return $res;
	}
	
	public function setShopOrderDetail($id, $dataArray) {
		$res = $this->update ( 'shop_order_detail', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrderDetail($id) {
		$res = $this->delete ( 'shop_order_detail', ' id="' . $id . '" ' );
		return $res;
	}
}