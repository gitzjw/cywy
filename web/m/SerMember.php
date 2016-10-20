<?php
final class SerMemberModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSerMember($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `service_member` ';
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
	
	public function addSerMember($data) {
		
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['sName'] = $data ['sName'];
		$dataArray ['sTelNumber'] = $data ['sTelNumber'];
		$dataArray ['sStatus'] = $data ['sStatus'];
		
		$res = $this->insert ( 'service_member', $dataArray );
		return $res;
	}
	
	public function setSerMember($id, $dataArray) {
		$res = $this->update ( 'service_member', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSerMember($id) {
		$res = $this->delete ( 'service_member', ' id="' . $id . '" ' );
		return $res;
	}
}
