<?php
final class ShopSpeUserModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopSpeUser($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_spe_user` ';
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
	
	public function addShopSpeUser($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['openid'] = $data ['openid'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['sName'] = $data ['sName'];
		$dataArray ['sTel'] = $data ['sTel'];
		$dataArray ['sEmail'] = $data ['sEmail'];
		$dataArray ['city'] = $data ['city'];
		$dataArray ['sStatus'] = $data ['sStatus'];
		$dataArray ['shopCode'] = $data ['shopCode'];
		
		$res = $this->insert ( 'shop_spe_user', $dataArray );
		return $res;
	}
	
	public function setShopSpeUser($id, $dataArray) {
		$res = $this->update ( 'shop_spe_user', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopSpeUser($id) {
		$res = $this->delete ( 'shop_spe_user', ' id="' . $id . '" ' );
		return $res;
	}
}