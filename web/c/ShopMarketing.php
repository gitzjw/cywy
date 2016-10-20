<?php
final class ShopMarketingController extends Base {
	
	public function getShopMarketing() {
		$soObj = new ShopOrderController ();
		$isFirstOrder = $soObj->isFirstOrder ();
		if ($isFirstOrder) {
			$this->_jsonEn ( '602', '没有优惠活动' );
		} else {
			$shopObj = new CakeShopController ();
			$shopRes = $shopObj->getCakeShopUid ();
			$_currentDate = date ( 'Y-m-d' );
			$w = ' sTime<="' . $_currentDate . '" and eTime>="' . $_currentDate . '" and city="' . $shopRes ['city'] . '" ';
			$obj = new ShopMarketingModel ();
			$res = $obj->getShopMarketing ( $w, 'money', '' );
			if ($res) {
				$this->_jsonEn ( '1', $res );
			} else {
				$this->_jsonEn ( '602', '没有优惠活动' );
			}
		}
	}
	
	public function getShopMarketingPro($_returnRes = 1, $_m = 1) {
		$soObj = new ShopOrderController ();
		if($_m==1){
			$isFirstOrder = $soObj->isFirstOrder ();
		}else{
			$isFirstOrder = false;
		}		
		if ($isFirstOrder) {
			if ($_returnRes) {
				$this->_jsonEn ( '602', '没有赠品活动' );
			} else {
				return false;
			}
		} else {
			$shopObj = new CakeShopController ();
			$shopRes = $shopObj->getCakeShopUid ();
			$_money = Run::req ( '_m' );
			if (! $_money) {
				$_money = $_m;
			}
			$_currentDate = date ( 'Y-m-d' );
			$w = ' wType="2" and sTime<="' . $_currentDate . '" and eTime>="' . $_currentDate . '" and city="' . $shopRes ['city'] . '" and money<="' . $_money . '" ';
			
			$obj = new ShopMarketingModel ();
			$res = $obj->getShopMarketing ( $w, ' money desc ', '', 1 );
			if ($res) {
				$res = $this->_zp ( $res ['pro'], $shopRes ['city'] );
				if ($_returnRes) {
					$this->_jsonEn ( '1', $res );
				} else {
					return $res;
				}
			} else {
				if ($_returnRes) {
					$this->_jsonEn ( '602', '没有赠品活动' );
				} else {
					return false;
				}
			}
		}
	}
	
	private function _zp($res, $city) {
		$_tmpPro = array ();
		$_proObj = new ShopProModel ();
		$_proObj->setTableCity ( $city );
		$_proObj->setField ( 'title,nPrice,marketPrice,id' );
		$res = explode ( ',', $res );
		foreach ( $res as $k => $v ) {
			$_tmpData = explode ( '-', $v );
			$_tmpRes = $_proObj->getShopPro ( 'id="' . $_tmpData [0] . '"', '', '', '1' );
			$_tmpPro [$k] = array ('title' => $_tmpRes ['title'], 'price' => (floatval ( $_tmpRes ['marketPrice'] ) * intval ( $_tmpData [1] )), 'num' => $_tmpData [1], 'id' => $_tmpRes ['id'] );
		}
		return $_tmpPro;
	}
	
	//uId查询商店
	public function getCakeShopUid($_s = '') {
		$users = $this->getUserDetail ();
		$_uid = $users ['id'];
		$obj = new CakeShopModel ();
		if ($_s == '') {
			$w = ' uId="' . $_uid . '" and status="2" ';
		} else {
			$w = ' uId="' . $_uid . '" ';
		}
		$res = $obj->getCakeShop ( $w, '', '', '1' );
		if ($res) {
			$this->_jsonEn ( '1', $res );
		} else {
			$this->_jsonEn ( '603', '没有该用户' );
		}
	}
	
	//查询可用优惠码
	public function getShopInvCode() {
		$obj = new ShopInvCodeModel ();
		$obj->setField ( 'codeNum' );
		$res = $obj->getShopInvCode ( 'codeStatus="1"' );
		echo json_encode ( $res );
		exit ();
	}
	
	//查询每个城市的每月销售商品
	public function getShopGoodsDate() {
		$_city = Run::req ( 'city' );
		
		if (! $_city) {
			$w = '';
		} else {
			$w = 'AND so.city="' . $_city . '"';
		}
		$_date = Run::req ( 'date' );
		if (! $_date) {
			echo '';
			exit ();
		}
		
		$_date = Run::getFormatDate ( $_date, 'Y-m' );
		
		$obj = new ShopProModel ();
		
		$sql = 'SELECT (SELECT sptm FROM shop_pro_100001 AS sp1 WHERE sp1.id=sod.pId) AS sptm,pId,pTitle,SUM(`eNum`) AS pTotal,sum(`tPrice`) as pTotalPrice,ePrice FROM shop_order so,shop_order_detail sod WHERE (so.oStatus="6" or so.oStatus="2" or so.oStatus="4") AND so.id=sod.oId AND so.createTime LIKE "' . $_date . '%" ' . $w . '  GROUP BY pTitle ORDER BY pTotal desc';
		//		echo $sql;
		$res = $obj->get_all ( $sql );
		if (! $res) {
			echo '';
			exit ();
		} else {
			echo json_encode ( $res );
			exit ();
		}
	}

}