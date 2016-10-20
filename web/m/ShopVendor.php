<?php
final class ShopVendorModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopVendor($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_vendor` ';
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
	
	public function addShopVendor($data) {
		
		$dataArray ['vName'] = $data ['vName'];
		$dataArray ['vTel'] = $data ['vTel'];
		$dataArray ['vEmail'] = $data ['vEmail'];
		$dataArray ['vAddress'] = $data ['vAddress'];
		$dataArray ['vStatus'] = $data ['vStatus'];
		
		$res = $this->insert ( 'shop_vendor', $dataArray );
		return $res;
	}
	
	public function setShopVendor($id, $dataArray) {
		$res = $this->update ( 'shop_vendor', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopVendor($id) {
		$res = $this->delete ( 'shop_vendor', ' id="' . $id . '" ' );
		return $res;
	}
}