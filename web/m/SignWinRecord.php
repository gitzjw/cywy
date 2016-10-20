<?php
final class SignWinRecordModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSignWinRecord($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `sign_win_record` ';
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
	
	public function addSignWinRecord($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['scId'] = $data ['scId'];
		$dataArray ['cMonth'] = $data ['cMonth'];
		$dataArray ['createDate'] = $data ['createDate'];
		$dataArray ['status'] = $data ['status'];
		$dataArray ['spId'] = $data ['spId'];
		$dataArray ['oUser'] = $data ['oUser'];
		$dataArray ['oImg'] = $data ['oImg'];
		
		$res = $this->insert ( 'sign_win_record', $dataArray );
		return $res;
	}
	
	public function setSignWinRecord($id, $dataArray) {
		$res = $this->update ( 'sign_win_record', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSignWinRecord($id) {
		$res = $this->delete ( 'sign_win_record', ' id="' . $id . '" ' );
		return $res;
	}
}
