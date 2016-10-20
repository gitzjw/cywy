<?php
final class CakeShopModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f='*'){
		$this->_f = $f;
	}
	
	public function getCakeShop($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `cake_shop` ';
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
	
	public function addCakeShop($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['shopMainName'] = $data ['shopMainName'];
		$dataArray ['shopName'] = $data ['shopName'];
		$dataArray ['shopAddress'] = $data ['shopAddress'];
		$dataArray ['shopTel'] = $data ['shopTel'];
		$dataArray ['city'] = $data ['city'];
		$dataArray ['shopInvCode'] = isset($data ['shopInvCode'])?$data ['shopInvCode']:'';
		$dataArray ['createTime'] = $data ['createTime'];
		$dataArray ['status'] = $data ['status'];
		
		$res = $this->insert ( 'cake_shop', $dataArray );
		return $res;
	}
	
	public function setCakeShop($id, $dataArray) {
		$res = $this->update ( 'cake_shop', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delCakeShop($id) {
		$res = $this->delete ( 'cake_shop', ' id="' . $id . '" ' );
		return $res;
	}
}