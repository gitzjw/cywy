<?php
final class SignDayConfigModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSignDayConfig($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `sign_day_config` ';
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
	
	public function addSignDayConfig($data) {
		
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['title'] = $data ['title'];
		$dataArray ['cDate'] = $data ['cDate'];
		$dataArray ['cDayNum'] = $data ['cDayNum'];
		$dataArray ['cSpeDate'] = $data ['cSpeDate'];
		
		$res = $this->insert ( 'sign_day_config', $dataArray );
		return $res;
	}
	
	public function setSignDayConfig($id, $dataArray) {
		$res = $this->update ( 'sign_day_config', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSignDayConfig($id) {
		$res = $this->delete ( 'sign_day_config', ' id="' . $id . '" ' );
		return $res;
	}
}
