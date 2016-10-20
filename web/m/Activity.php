<?php
final class ActivityModel extends Mysql {
	
	public $_f = '*', $_t = '';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function setTable($t = '') {
		$this->_t = $t;
	}
	
	public function getActivity($where = '', $orderby = '', $limit = '', $solo = '') {
		if (empty ( $this->_t )) {
			return false;
		}
		$sql = 'select ' . $this->_f . ' from `act' . $this->_t . '` ';
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
	
	public function addActivity($data) {
		if (empty ( $data ) || ! is_array ( $data )) {
			return false;
		}
		if (empty ( $this->_t )) {
			return false;
		}
		$res = $this->insert ( '`act' . $this->_t . '`', $data );
		return $res;
	}
	
	public function setActivity($id, $dataArray) {
		if (empty ( $this->_t )) {
			return false;
		}
		$res = $this->update ( '`act' . $this->_t . '`', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}

}