<?php
final class SignMainRecordModel extends Mysql {

	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSignMainRecord($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `sign_main_record` ';
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
	
	public function addSignMainRecord($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['sMonth'] = $data ['sMonth'];
		$dataArray ['sDate'] = $data ['sDate'];
		$dataArray ['sTime'] = $data ['sTime'];
		
		$res = $this->insert ( 'sign_main_record', $dataArray );
		return $res;
	}
	
	public function setSignMainRecord($id, $dataArray) {
		$res = $this->update ( 'sign_main_record', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSignMainRecord($id) {
		$res = $this->delete ( 'sign_main_record', ' id="' . $id . '" ' );
		return $res;
	}
}
