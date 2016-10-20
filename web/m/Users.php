<?php
final class UsersModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f='*'){
		$this->_f = $f;
	}
	
	public function getUsers($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `users` ';
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
	
	public function addUsers($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['idCard'] = $data ['idCard'];
		$dataArray ['telNumber'] = $data ['telNumber'];
		$dataArray ['openId'] = $data ['openId'];
		$dataArray ['uType'] = $data ['uType'];
		$dataArray ['uPwd'] = $data ['uPwd'];
		$dataArray ['uStatus'] = $data ['uStatus'];
		$dataArray ['uCreateDate'] = $data ['uCreateDate'];
		
		$res = $this->insert ( 'users', $dataArray );
		return $res;
	}
	
	public function setUsers($id, $dataArray) {
		$res = $this->update ( 'users', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delUsers($id) {
		$res = $this->delete ( 'users', ' id="' . $id . '" ' );
		return $res;
	}
}