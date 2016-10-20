<?php
final class ShopProModel extends Mysql {
	
	public $_f = '*';
	
	public $_tab = 'shop_pro';
	
	public function setField($f = '*') {
		$this->_f = $f;
	}
	
	public function setTableCity($t = '100001') {
		if (empty ( $t )) {
			$t = '100001';
		}
		$this->_tab = 'shop_pro_' . $t;
	}
	
	public function getShopPro($where = '', $orderby = '', $limit = '', $solo = '') {
		$sql = 'select ' . $this->_f . ' from ' . $this->_tab . ' ';
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
	
	public function addShopPro($data) {
		
		$dataArray ['wType'] = $data ['wType'];
		$dataArray ['listImgPath'] = $data ['listImgPath'];
		$dataArray ['dImgPath'] = $data ['dImgPath'];
		$dataArray ['title'] = $data ['title'];
		$dataArray ['sNorms'] = $data ['sNorms'];
		$dataArray ['sUnit'] = $data ['sUnit'];
		$dataArray ['oPrice'] = $data ['oPrice'];
		$dataArray ['dPrice'] = $data ['dPrice'];
		$dataArray ['nPrice'] = $data ['nPrice'];
		$dataArray ['oNum'] = $data ['oNum'];
		$dataArray ['sNum'] = $data ['sNum'];
		$dataArray ['nNum'] = $data ['nNum'];
		$dataArray ['spDesc'] = $data ['spDesc'];
		$dataArray ['spContent'] = $data ['spContent'];
		$dataArray ['isTop'] = $data ['isTop'];
		$dataArray ['spSort'] = $data ['spSort'];
		$dataArray ['isIndex'] = $data ['isIndex'];
		$dataArray ['aLif'] = $data ['aLif'];
		$dataArray ['spStatus'] = $data ['spStatus'];
		$dataArray ['goodsNote'] = $data ['goodsNote'];
		$dataArray ['sptm'] = $data ['sptm'];
		$dataArray ['sUnitNum'] = $data ['sUnitNum'];
		$dataArray ['marketPrice'] = $data ['marketPrice'];
		$dataArray ['speMark'] = $data ['speMark'];
		
		$res = $this->insert ( $this->_tab, $dataArray );
		return $res;
	}
	
	public function setShopPro($id, $dataArray) {
		$res = $this->update ( $this->_tab, $dataArray, ' id="' . $id . '" ' );
		return $res;
	}
	
	public function delShopPro($id) {
		$res = $this->delete ( $this->_tab, ' id="' . $id . '" ' );
		return $res;
	}

	//获取商品父级分类
	public function getGoodType($good_id){
		if(empty($good_id)){
			return 0;
		}
		$sql = "select wType from shop_pro_100001 where id = ".$good_id;
		$typeId = $this->get_one ( $sql );
		$sqlType = "select parentId from shop_type where id = ".$typeId['wType'];
		$parentId = $typeId = $this->get_one ( $sqlType );
		return $parentId;
	}
}