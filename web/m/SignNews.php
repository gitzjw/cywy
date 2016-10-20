<?php
final class SignNewsModel extends Mysql {

	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSignNews($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `sign_news` ';
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
	
	public function addSignNews($data) {
		
		$dataArray ['title'] = $data ['title'];
		$dataArray ['subTitle'] = $data ['subTitle'];
		$dataArray ['picUrl'] = $data ['picUrl'];
		$dataArray ['hrefUrl'] = $data ['hrefUrl'];
		$dataArray ['sDate'] = $data ['sDate'];
		$dataArray ['mId'] = $data ['mId'];
		$dataArray ['createDate'] = $data ['createDate'];
		$dataArray ['status'] = $data ['status'];		
		
		$res = $this->insert ( 'sign_news', $dataArray );
		return $res;
	}
	
	public function setSignNews($id, $dataArray) {
		$res = $this->update ( 'sign_news', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSignNews($id) {
		$res = $this->delete ( 'sign_news', ' id="' . $id . '" ' );
		return $res;
	}
}
