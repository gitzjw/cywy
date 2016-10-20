<?php
final class ShopVendorProModel extends Mysql {
	
	public $_f = '*';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function getShopVendorPro($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from `shop_vendor_pro` ';
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
	
	public function addShopVendorPro($data) {
		
		$dataArray ['vId'] = $data ['vId'];
		$dataArray ['vName'] = $data ['vName'];
		$dataArray ['pId'] = $data ['pId'];
		$dataArray ['pTitle'] = $data ['pTitle'];
		$dataArray ['wTypePid'] = $data ['wTypePid'];
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['price'] = $data ['price'];
		$dataArray ['pmark'] = $data ['pmark'];
		
		$res = $this->insert ( 'shop_vendor_pro', $dataArray );
		return $res;
	}
	
	public function setShopVendorPro($id, $dataArray) {
		$res = $this->update ( 'shop_vendor_pro', $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopVendorPro($id) {
		$res = $this->delete ( 'shop_vendor_pro', ' id="' . $id . '" ' );
		return $res;
	}
}