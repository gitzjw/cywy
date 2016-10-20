<?php
final class InsPayModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getInsPay($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `insurance_pay` ';
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
	
	public function addInsPay($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['rPay'] = $data ['rPay'];
		$dataArray ['rPayCode'] = $data ['rPayCode'];
		$dataArray ['rPayTime'] = $data ['rPayTime'];
		$dataArray ['rCreateTime'] = $data ['rCreateTime'];
		$dataArray ['rSpan'] = $data ['rSpan'];
		$dataArray ['rStatus'] = $data ['rStatus'];
		$dataArray ['uId'] = $data ['uId'];
		
		$res = $this->insert ( 'insurance_pay', $dataArray );
		return $res;
	}
	
	public function setInsPay($id, $dataArray) {
		$res = $this->update ( 'insurance_pay', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delInsPay($id) {
		$res = $this->delete ( 'insurance_pay', ' id="' . $id . '" ' );
		return $res;
	}
}