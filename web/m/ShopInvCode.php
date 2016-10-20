<?php
final class ShopInvCodeModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopInvCode($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_inv_code` ';
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
	
	public function addShopInvCode($data) {
				
		$dataArray ['codeName'] = $data ['codeName'];
		$dataArray ['codeNum'] = $data ['codeNum'];
		
		$res = $this->insert ( 'shop_inv_code', $dataArray );
		return $res;
	}
	
	public function setShopInvCode($id, $dataArray) {
		$res = $this->update ( 'shop_inv_code', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopInvCode($id) {
		$res = $this->delete ( 'shop_inv_code', ' id="' . $id . '" ' );
		return $res;
	}
}
