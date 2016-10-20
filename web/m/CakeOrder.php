<?php
final class CakeOrderModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f='*'){
		$this->_f = $f;
	}
	
	public function getCakeOrder($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `cake_order` ';
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
	
	public function addCakeOrder($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['cpId'] = $data ['cpId'];
		$dataArray ['cpName'] = $data ['cpName'];
		$dataArray ['cpImg'] = $data ['cpImg'];
		$dataArray ['sendType'] = $data ['sendType'];
		$dataArray ['oAddress'] = $data ['oAddress'];
		$dataArray ['oName'] = $data ['oName'];
		$dataArray ['oTel'] = $data ['oTel'];
		$dataArray ['rTime'] = $data ['rTime'];
		$dataArray ['petName'] = $data ['petName'];
		$dataArray ['petSex'] = $data ['petSex'];
		$dataArray ['petBirthday'] = $data ['petBirthday'];
		$dataArray ['payMoney'] = $data ['payMoney'];
		$dataArray ['payCode'] = $data ['payCode'];
		$dataArray ['payTime'] = $data ['payTime'];
		$dataArray ['createTime'] = $data ['createTime'];		
		$dataArray ['oUser'] = $data ['oUser'];
		$dataArray ['oMsg'] = $data ['oMsg'];
		$dataArray ['status'] = $data ['status'];
		
		$res = $this->insert ( 'cake_order', $dataArray );
		return $res;
	}
	
	public function setCakeOrder($id, $dataArray) {
		$res = $this->update ( 'cake_order', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delCakeOrder($id) {
		$res = $this->delete ( 'cake_order', ' id="' . $id . '" ' );
		return $res;
	}
}