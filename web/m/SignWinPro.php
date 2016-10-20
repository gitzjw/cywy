<?php
final class SignWinProModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getSignWinPro($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `sign_win_pro` ';
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
	
	public function addSignWinPro($data) {
		
		$dataArray ['title'] = $data ['title'];
		$dataArray ['subTitle'] = $data ['subTitle'];
		$dataArray ['winMsg'] = $data ['winMsg'];
		$dataArray ['content'] = $data ['content'];
		$dataArray ['cDate'] = $data ['cDate'];
		$dataArray ['imgPath'] = $data ['imgPath'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['scId'] = $data ['scId'];
		$dataArray ['oMark'] = $data ['oMark'];
		
		$res = $this->insert ( 'sign_win_pro', $dataArray );
		return $res;
	}
	
	public function setSignWinPro($id, $dataArray) {
		$res = $this->update ( 'sign_win_pro', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delSignWinPro($id) {
		$res = $this->delete ( 'sign_win_pro', ' id="' . $id . '" ' );
		return $res;
	}
}
