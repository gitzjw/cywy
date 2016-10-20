<?php
final class ShopOrderAllotBdModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopOrderAllotBd($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_order_allot_bd` ';
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
	
	public function getJoinShopOrder($_uid){
		$sql = 'SELECT so.id,so.oName,so.oShopName,so.oTel,so.oAddress,so.oStatus,so.oMoney,so.nMoney,so.createTime,so.totalNum 
		FROM shop_order_allot_bd soa,shop_order so WHERE soa.oId=so.id AND soa.bdUid="'.$_uid.'"  AND so.oStatus NOT IN (1,3) ';
		$res = $this->get_all($sql);
		if($res){
			return $res;
		}else{
			return array();
		}
	}
	
	public function addShopOrderAllotBd($data) {
		
		$dataArray ['oId'] = $data ['oId'];
		$dataArray ['bdUid'] = $data ['bdUid'];
		$dataArray ['bdName'] = $data ['bdName'];
		$dataArray ['bdCity'] = $data ['bdCity'];
		$dataArray ['createDate'] = date('Y-m-d H:i:s');
		
		$res = $this->insert ( 'shop_order_allot_bd', $dataArray );
		return $res;
	}
	
	public function setShopOrderAllotBd($id, $dataArray) {
		$res = $this->update ( 'shop_order_allot_bd', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopOrderAllotBd($id) {
		$res = $this->delete ( 'shop_order_allot_bd', ' id="' . $id . '" ' );
		return $res;
	}
}