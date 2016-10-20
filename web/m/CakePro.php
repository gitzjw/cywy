<?php
final class CakeProModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f='*'){
		$this->_f = $f;
	}
	
	public function getCakePro($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select '.$this->_f.' from `cake_pro` ';
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
	
	public function addCakePro($data) {
		
		$dataArray ['listImgPath'] = $data ['listImgPath'];
		$dataArray ['dNum'] = $data ['dNum'];
		$dataArray ['imgPath'] = $data ['imgPath'];
		$dataArray ['title'] = $data ['title'];
		$dataArray ['oPrice'] = $data ['oPrice'];
		$dataArray ['dPrice'] = $data ['dPrice'];
		$dataArray ['nPrice'] = $data ['nPrice'];
		$dataArray ['content'] = $data ['content'];
		$dataArray ['createTime'] = $data ['createTime'];
		$dataArray ['isTop'] = $data ['isTop'];
		$dataArray ['QRcode'] = $data ['QRcode'];
		$dataArray ['htmlUrl'] = $data ['htmlUrl'];
		$dataArray ['status'] = $data ['status'];
		
		$res = $this->insert ( 'cake_pro', $dataArray );
		return $res;
	}
	
	public function setCakePro($id, $dataArray) {
		$res = $this->update ( 'cake_pro', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delCakePro($id) {
		$res = $this->delete ( 'cake_pro', ' id="' . $id . '" ' );
		return $res;
	}
}