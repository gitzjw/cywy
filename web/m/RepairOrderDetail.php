<?php
final class RepairOrderDetailModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getRepairOrderDetail($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `repair_order_detail` ';
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
	
	public function addRepairOrderDetail($data) {
		
		$dataArray ['oId'] = $data ['oId'];
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['odNum'] = $data ['odNum'];
		$dataArray ['odPrice'] = $data ['odPrice'];
		$dataArray ['odStatus'] = $data ['odStatus'];
		$dataArray ['odExpNum'] = $data ['odExpNum'];
		$dataArray ['odExpContent'] = $data ['odExpContent'];
		
		$res = $this->insert ( 'repair_order_detail', $dataArray );
		return $res;
	}
	
	public function setRepairOrderDetail($id, $dataArray) {
		$res = $this->update ( 'repair_order_detail', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function setRepairOrderDetailOid($oid, $dataArray) {
		$res = $this->update ( 'repair_order_detail', $dataArray, ' oId="' . $oid . '" ' );
		return $res;
	}
	
	public function delRepairOrderDetail($id) {
		$res = $this->delete ( 'repair_order_detail', ' id="' . $id . '" ' );
		return $res;
	}
}