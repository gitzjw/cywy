<?php
final class CakeShopEuiController extends Base {
	public function getCakeShopList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new CakeShopModel ();
		$ueObj->setField ( '*,(select sName from shop_spe_user sp where sp.shopCode=shopInvCode) as shopInvCodeName' );
		$w = $this->getWhere ();
		$res = $ueObj->getCakeShop ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getCakeShop ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_name = Run::req ( '_name' );
		$_mainname = Run::req ( '_mainname' );
		$_tel = Run::req ( '_tel' );
		if (! $_name && ! $_tel && ! $_mainname) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_mainname) {
			$w .= ' and shopMainName="' . $_mainname . '" ';
		}
		if ($_name) {
			$w .= ' and shopName="' . $_name . '" ';
		}
		if ($_tel) {
			$w .= ' and shopTel="' . $_tel . '" ';
		}
		return $w;
	}
	
	public function getCakeShopDetail($_id) {
		$obj = new CakeShopModel ();
		$res = $obj->getCakeShop ( 'id="' . $_id . '"', '', '1', '1' );
		return $res;
	}
	
	public function updateStatus() {
		$_s = Run::req ( '_s' );
		$_id = Run::req ( '_id' );
		$obj = new CakeShopModel ();
		$data ['status'] = $_s;
		$res = $obj->setCakeShop ( $_id, $data );
		if ($res) {
			if ($_s == "2") {
				$info = '【宠业无忧】恭喜您，商家身份绑定审核通过，可以在宠业无忧平台上进货、订购宠物蛋糕啦，如有问题请咨询4007-007-580，回N退订';
				$shopRes = $this->getCakeShopDetail ( $_id );
				$mgsRes = Run::sendMessage ( trim ( $shopRes ['shopTel'] ), $info, '0' );
			}
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function saveCakeShop() {
		$_id = Run::req ( 'id' );
		if (empty ( $_id )) {
			echo '操作失败';
			exit ();
		}
		
		$obj = new CakeShopModel ();
		$res = $obj->getCakeShop ( 'id="' . $_id . '"', '', '1', '1' );
		if (empty ( $res )) {
			echo '操作失败，没有查询到数据';
			exit ();
		} else {
			$_d ['shopAddress'] = Run::req ('shopAddress');
			$_d ['shopTel'] = Run::req ('shopTel');
			$_d ['shopMainName'] = Run::req ('shopMainName');
			$_d ['shopName'] = Run::req ('shopName');
			$_d ['city'] = Run::req ('city');
			$_d ['shopInvCode'] = Run::req ('shopInvCode');
			
			$obj->setCakeShop ( $_id, $_d );
			echo '操作成功';
			exit ();
		}
	}
}