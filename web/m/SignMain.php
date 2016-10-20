<?php
final class SignMainModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSignMain($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `sign_main` ';
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
	
	public function addSignMain($data) {
		
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['mTotalNum'] = $data ['mTotalNum'];
		$dataArray ['mContNum'] = $data ['mContNum'];
		$dataArray ['sTotalNum'] = $data ['sTotalNum'];
		$dataArray ['sContNum'] = $data ['sContNum'];
		
		$res = $this->insert ( 'sign_main', $dataArray );
		return $res;
	}
	
	public function setSignMain($id, $dataArray) {
		$res = $this->update ( 'sign_main', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSignMain($id) {
		$res = $this->delete ( 'sign_main', ' id="' . $id . '" ' );
		return $res;
	}
}
