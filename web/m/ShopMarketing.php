<?php
final class ShopMarketingModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopMarketing($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_marketing` ';
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
	
	public function addShopMarketing($data) {
		
		$dataArray ['sTime'] = $data ['sTime'];
		$dataArray ['eTime'] = $data ['eTime'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['money'] = $data ['money'];
		$dataArray ['nMoney'] = $data ['nMoney'];
		$dataArray ['pro'] = $data ['pro'];
		$dataArray ['oMark'] = $data ['oMark'];
		$dataArray ['city'] = $data ['city'];
		
		$res = $this->insert ( 'shop_marketing', $dataArray );
		return $res;
	}
	
	public function setShopMarketing($id, $dataArray) {
		$res = $this->update ( 'shop_marketing', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopMarketing($id) {
		$res = $this->delete ( 'shop_marketing', ' id="' . $id . '" ' );
		return $res;
	}
}