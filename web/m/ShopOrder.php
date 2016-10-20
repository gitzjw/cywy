<?php
final class ShopOrderModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrder($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order` ';
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
	
	public function addShopOrder($data) {
		
		$dataArray ['id'] = $data ['id'];
		$dataArray ['uId'] = $data ['uId'];
		$dataArray ['oName'] = $data ['oName'];
		$dataArray ['oShopName'] = $data ['oShopName'];
		$dataArray ['oTel'] = $data ['oTel'];
		$dataArray ['oAddress'] = $data ['oAddress'];
		$dataArray ['city'] = $data ['city'];
		$dataArray ['oMoney'] = $data ['oMoney'];
		$dataArray ['dMoney'] = $data ['dMoney'];
		$dataArray ['nMoney'] = $data ['nMoney'];
		$dataArray ['totalNum'] = $data ['totalNum'];
		$dataArray ['createTime'] = $data ['createTime'];
		$dataArray ['payTime'] = $data ['payTime'];
		$dataArray ['payCode'] = $data ['payCode'];
		$dataArray ['oStatus'] = $data ['oStatus'];
		$dataArray ['oMark'] = $data ['oMark'];
		$dataArray ['expMoney'] = $data ['expMoney'];
		
		$res = $this->insert ( 'shop_order', $dataArray );
		return $res;
	}
	
	public function setShopOrder($id, $dataArray) {
		$res = $this->update ( 'shop_order', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrder($id) {
		$res = $this->delete ( 'shop_order', ' id="' . $id . '" ' );
		return $res;
	}
}