<?php
final class InsPriceModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getInsPrice($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `insurance_price` ';
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
	
	public function addInsPrice($data) {
		
		$dataArray ['pSpan'] = $data ['pSpan'];
		$dataArray ['pDis'] = $data ['pDis'];
		$dataArray ['pPrice'] = $data ['pPrice'];
		$dataArray ['pNPrice'] = $data ['pNPrice'];
		$dataArray ['pStatus'] = $data ['pStatus'];
		
		$res = $this->insert ( 'insurance_price', $dataArray );
		return $res;
	}
	
	public function setInsPrice($id, $dataArray) {
		$res = $this->update ( 'insurance_price', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delInsPrice($id) {
		$res = $this->delete ( 'insurance_price', ' id="' . $id . '" ' );
		return $res;
	}
}