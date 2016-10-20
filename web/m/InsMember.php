<?php
final class InsMemberModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getInsMember($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `insurance_member` ';
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
	
	public function addInsMember($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['iName'] = $data ['iName'];
		$dataArray ['iSex'] = $data ['iSex'];
		$dataArray ['iAge'] = $data ['iAge'];
		$dataArray ['iIdCard'] = $data ['iIdCard'];
		$dataArray ['iTelNumber'] = $data ['iTelNumber'];
		$dataArray ['iAddress'] = $data ['iAddress'];
		$dataArray ['iUserId'] = $data ['iUserId'];
		$dataArray ['iCreateDate'] = $data ['iCreateDate'];
		$dataArray ['iuStatus'] = $data ['iuStatus'];
		
		$res = $this->insert ( 'insurance_member', $dataArray );
		return $res;
	}
	
	public function setInsMember($id, $dataArray) {
		$res = $this->update ( 'insurance_member', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delInsMember($id) {
		$res = $this->delete ( 'insurance_member', ' id="' . $id . '" ' );
		return $res;
	}
}
