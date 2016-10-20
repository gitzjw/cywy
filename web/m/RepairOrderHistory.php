<?php
final class RepairOrderHistoryModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getRepairOrderHistory($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `repair_order_history` ';
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
	
	public function addRepairOrderHistory($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['oId'] = $data ['oId'];
		$dataArray ['createTime'] = $data ['createTime'];
		$dataArray ['ohStatus'] = $data ['ohStatus'];
		$dataArray ['ohText'] = $data ['ohText'];
		
		$res = $this->insert ( 'repair_order_history', $dataArray );
		return $res;
	}
	
	public function setRepairOrderHistory($id, $dataArray) {
		$res = $this->update ( 'repair_order_history', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delRepairOrderHistory($id) {
		$res = $this->delete ( 'repair_order_history', ' id="' . $id . '" ' );
		return $res;
	}
}