<?php
final class ShopOrderProLackModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrderProLack($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order_pro_lack` ';
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
		
	public function addShopOrderProLack($data) {
		
		$dataArray ['pId'] = $data ['pId'];
		$dataArray ['sptm'] = $data ['sptm'];
		$dataArray ['pTitle'] = $data ['pTitle'];
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['city'] = $data ['city'];
		$dataArray ['pNum'] = $data ['pNum'];
		$dataArray ['createTime'] = date('Y-m-d H:i:s');
		
		$res = $this->insert ( 'shop_order_pro_lack', $dataArray );
		return $res;
	}
	
	public function setShopOrderProLack($id, $dataArray) {
		$res = $this->update ( 'shop_order_pro_lack', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrderProLack($id) {
		$res = $this->delete ( 'shop_order_pro_lack', ' id="' . $id . '" ' );
		return $res;
	}
}