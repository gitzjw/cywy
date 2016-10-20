<?php
final class RepairOrderModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getRepairOrder($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `repair_order` ';
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
	
	public function addRepairOrder($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['roCity'] = $data ['roCity'];
		$dataArray ['mAddress'] = $data ['mAddress'];
		$dataArray ['bAddress'] = $data ['bAddress'];
		$dataArray ['cAddress'] = $data ['cAddress'];
		$dataArray ['roPrice'] = $data ['roPrice'];
		$dataArray ['roStatus'] = $data ['roStatus'];
		$dataArray ['roExpNum'] = $data ['roExpNum'];
		$dataArray ['roExpContent'] = $data ['roExpContent'];
		$dataArray ['roCreateDate'] = $data ['roCreateDate'];
		$dataArray ['roPayDate'] = $data ['roPayDate'];
		$dataArray ['roPayCode'] = $data ['roPayCode'];
		$dataArray ['roMark'] = $data ['roMark'];
		
		$res = $this->insert ( 'repair_order', $dataArray );
		return $res;
	}
	
	public function setRepairOrder($id, $dataArray) {
		$res = $this->update ( 'repair_order', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delRepairOrder($id) {
		$res = $this->delete ( 'repair_order', ' id="' . $id . '" ' );
		return $res;
	}
}