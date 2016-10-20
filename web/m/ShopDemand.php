<?php
final class ShopDemandModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopDemand($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_demand` ';
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
	
	public function addShopDemand($data) {
		
		$dataArray ['content'] = $data ['content'];
		$dataArray ['tel'] = $data ['tel'];
		$dataArray ['createTime'] = $data ['createTime'];
		
		
		$res = $this->insert ( 'shop_demand', $dataArray );
		return $res;
	}
	
	public function setShopDemand($id, $dataArray) {
		$res = $this->update ( 'shop_demand', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopDemand($id) {
		$res = $this->delete ( 'shop_demand', ' id="' . $id . '" ' );
		return $res;
	}
}