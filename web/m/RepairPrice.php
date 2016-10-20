<?php
final class RepairPriceModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f='*'){
		$this->_f = $f;
	}
	
	public function getRepairPrice($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `repair_price` ';
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
	
	public function addRepairPrice($data) {
		
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['rpCity'] = $data ['rpCity'];
		$dataArray ['oPrice'] = $data ['oPrice'];
		$dataArray ['dPrice'] = $data ['dPrice'];
		$dataArray ['nPrice'] = $data ['nPrice'];
		$dataArray ['rpStatus'] = $data ['rpStatus'];
		
		$res = $this->insert ( 'repair_price', $dataArray );
		return $res;
	}
	
	public function setRepairPrice($id, $dataArray) {
		$res = $this->update ( 'repair_price', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delRepairPrice($id) {
		$res = $this->delete ( 'repair_price', ' id="' . $id . '" ' );
		return $res;
	}
}