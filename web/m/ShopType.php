<?php
final class ShopTypeModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopType($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_type` ';
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
	
	public function addShopType($data) {
		
		$dataArray ['parentId'] = $data ['parentId'];
		$dataArray ['sName'] = $data ['sName'];
		$dataArray ['imgPath'] = $data ['imgPath'];
		$dataArray ['isTop'] = $data ['isTop'];
		$dataArray ['cSort'] = $data ['cSort'];
		$dataArray ['isIndex'] = $data ['isIndex'];
		$dataArray ['aLif'] = $data ['aLif'];
		$dataArray ['cStatus'] = $data ['cStatus'];
		$dataArray ['city'] = $data ['city'];
		
		$res = $this->insert ( 'shop_type', $dataArray );
		return $res;
	}
	
	public function setShopType($id, $dataArray) {
		$res = $this->update ( 'shop_type', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopType($id) {
		$res = $this->delete ( 'shop_type', ' id="' . $id . '" ' );
		return $res;
	}
}