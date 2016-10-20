<?php
final class ThirdSendGoodsController extends Base {
	
	private $_url = 'http://180.167.66.14:8097/GetData.aspx?';
	
	/**
	 * 校验商品
	 * $_city 城市  $_sptm 商品条形码，以“,”连接多个 
	 * @return true，校验成功 	 false，校验失败
	 */
	public function checkSptm($_city, $_car) {
		
		$shopObj = new ShopProModel ();
		$shopObj->setTableCity ( $_city );
		$shopObj->setField ( 'id,sptm,title,sUnitNum' );
		
		$_sptm = '';
		$_tmpShop = array ();
		foreach ( $_car as $k => $v ) {
			if (isset ( $v ['0'] ) && ! empty ( $v ['0'] )) {
				$_spr = $shopObj->getShopPro ( 'id="' . $v ['0'] . '"', '', '1', '1' );
				$_sptm .= $_spr ['sptm'] . ',';
				$_spr ['sUnitNumTotal'] = intval ( $v ['3'] ) * intval ( $_spr ['sUnitNum'] );
				$_tmpShop [$_spr ['sptm']] = $_spr;
			}
		}
		
		if ($_city == '100001') {
			$_url = $this->_url . 'action=getbjonhands&key=meng&sptm=' . $_sptm;
		} elseif ($_city == '200001') {
			$_url = $this->_url . 'action=getshonhands&key=meng&sptm=' . $_sptm;
		} elseif ($_city == '300001') {
			$_url = $this->_url . 'action=getshonhands&key=meng&sptm=' . $_sptm;
		}
		
		$_res = Run::getHttpRes ( $_url );
		
		$_res = json_decode ( $_res, true );
		
		$_returnRes = true;
		
		if (empty ( $_res )) {
			$_returnRes = false;
		}
		
		foreach ( $_res as $k => $v ) {
			if ($v ['minkys'] >= $_tmpShop [$v ['sptm']]['sUnitNumTotal']) {
			
			} else {
				$_returnRes = false;
				$_returnTitle = $v ['sptm'];
				break;
			}
		}
		
		if (! $_returnRes) {
			$this->_addProLack($_tmpShop [$_returnTitle], $_city);
			return array ('returnRes' => $_returnRes, 'title' => $_tmpShop [$_returnTitle] ['title'] );
		} else {
			return array ('returnRes' => $_returnRes, 'title' => '' );
		}
			
		//return $_returnRes;
	}
	
	/**
	 * 
	 * 缺货登记
	 * @param 数据组合 $_data
	 * @param 城市 $_city
	 */
	private function _addProLack($_data,$_city){
		$_u = $this->getUserDetail();
		$obj = new ShopOrderProLackModel();
				
		$dataArray ['pId'] = $_data ['id'];
		$dataArray ['sptm'] = $_data ['sptm'];
		$dataArray ['pTitle'] = $_data ['title'];
		$dataArray ['uId'] = $_u ['id'];
		$dataArray ['city'] = $_city;
		$dataArray ['pNum'] = $_data ['sUnitNumTotal'];
				
		$res = $obj->addShopOrderProLack($dataArray);
		return $res;
	}
	
	/**
	 * 发货
	 */
	public function createSendOrder($_orderId) {
		
		$_url = $this->_url . 'action=createsalesorder&key=meng';
		
		$orderRes = $this->getOrder ( $_orderId );
		$_cityName = '';
		$_pcityName = '';
		if ($orderRes ['city'] == '100001') {
			$_pData ['ckmc'] = '007';
			$_cityName = '北京市';
			$_pcityName = '北京市';
		} elseif ($orderRes ['city'] == '200001') {
			$_pData ['ckmc'] = '001';
			$_cityName = '上海市';
			$_pcityName = '上海市';
		} elseif ($orderRes ['city'] == '300001') {
			$_pData ['ckmc'] = '001';
			$_cityName = '深圳市';
			$_pcityName = '广东省';
		}else{
			$_pData ['ckmc'] = '007';
			$_cityName = '北京市';
			$_pcityName = '北京市';
		}
		
		
		$_pData ['lydh'] = $_orderId;
		$_pData ['shr'] = $orderRes ['oName'];
		$_pData ['dizhi'] = $orderRes ['oAddress'];
		$_pData ['shouji'] = $orderRes ['oTel'];		
		
		$_pData ['rq'] = $orderRes ['createTime'];
		
		$_pData ['sheng'] = $_pcityName;
		$_pData ['shi'] = $_cityName;
		$_pData ['qu'] = '';
		
		$_chilRes = $this->getOrderChil ( $_orderId, $orderRes ['city'] );
		
		$_pData ['row'] = $_chilRes ['spList'];
		$_pData ['zsl'] = $_chilRes ['total'];
		
		//$_pData ['zje'] = $orderRes ['oMoney'];
		$_pData ['zje'] = $_chilRes ['totalPrice'];
		$_pData ['wlfy'] = $orderRes['expMoney'];
		if ($orderRes ['payCode'] != '') {
			$_pData ['zffs'] = '013';
			$_pData ['zfje'] = ($_pData ['zje']-$orderRes ['dMoney'])+$orderRes['expMoney'];//$orderRes ['nMoney'];
			$_pData ['rlje'] = $orderRes ['dMoney'];
			$_pData ['jyh'] = $orderRes ['payCode'];
			$_pData ['zfrq'] = $orderRes ['payTime'];
			$_pData ['hdfk'] = '0';
		} else {
			$_pData ['zffs'] = '0000';
			$_pData ['zfje'] = '0';
			$_pData ['rlje'] = '0';
			$_pData ['jyh'] = '';
			$_pData ['zfrq'] = '';
			$_pData ['hdfk'] = '1';
		}
		
//		$_pData ['cyje'] = 0;
		
		$_postDataRes = json_encode ( $_pData ); //'inputdata=' . array ('inputdata' => $_postDataRes )
		
//		echo $_postDataRes;
//		exit ();
		

		$_res = Run::getHttpPostRes ( array ('inputdata' => $_postDataRes ), $_url );
		
		//		echo ($_res);exit;
		

		$_res = json_decode ( $_res, true );
		
		if ($_res ['code'] == '1') {
			$this->wlog ( APP_PATH . 'public/log/third_send_goods', $_res ['code'] . ' ' . $_res ['message'] . ' ' . $_res ['djbh'] );
		} else {
			$this->wlog ( APP_PATH . 'public/log/third_send_goods', $_res ['code'] . ' ' . $_res ['message'].' '.$_orderId );
		}
	
	}
	
	//查询订单
	private function getOrder($_orderId) {
		$obj = new ShopOrderModel ();
		return $obj->getShopOrder ( 'id="' . $_orderId . '"', '', '1', '1' );
	}
	
	//查询子订单
	private function getOrderChil($_orderId, $_city) {
		$obj = new ShopOrderDetailModel ();
		$obj->setField ( 'pId,eNum,ePrice' );
		$res = $obj->getShopOrderDetail ( 'oId="' . $_orderId . '"' );
		
		$shopObj = new ShopProModel ();
		$shopObj->setTableCity ( $_city );
		$shopObj->setField ( 'sptm,sUnitNum,nPrice' );
		
		$_tmpRes = array ();
		
		$_total = 0;
		$_totalPrice = 0;
		
		foreach ( $res as $k => $v ) {
			$_spr = $shopObj->getShopPro ( 'id="' . $v ['pId'] . '"', '', '1', '1' );
			$_tmpRes ['spList'] [$k] ['tm'] = $_spr ['sptm'];
			$_tmpRes ['spList'] [$k] ['sl'] = intval ( $v ['eNum'] ) * intval ( $_spr ['sUnitNum'] );
			if($_spr ['sUnitNum']=='1'){
				$_tmpRes ['spList'] [$k] ['sjdj'] = floatval($_spr['nPrice']);
			}else{
				$_tmpA = round(floatval($_spr['nPrice'])/intval($_spr ['sUnitNum']),2);
				$_tmpRes ['spList'] [$k] ['sjdj'] = $_tmpA;
			}
			$_total += $_tmpRes ['spList'] [$k] ['sl'];
			$_totalPrice = ($_tmpRes ['spList'] [$k] ['sjdj']*$_tmpRes ['spList'] [$k] ['sl'])+$_totalPrice;
		}
		$_tmpRes ['total'] = $_total;
		$_tmpRes ['totalPrice'] = $_totalPrice;
		return $_tmpRes;
	}
	
	//订单轮询
	public function planTask() {
		$obj = new ShopOrderModel ();
		$obj->setField ( 'id,oStatus,uId' );
		$res = $obj->getShopOrder ( 'oStatus="2"' );
		$_num = '';
		$_tmpRes = array ();
		foreach ( $res as $k => $v ) {
			$_num .= $v ['id'] . ',';
			$_tmpRes [$v ['id']] = $v;
		}
		
		if(empty($_num)){
			$this->wlog ( APP_PATH . 'public/log/third_upd_order', '暂无更新数据' );
		}
		
		$cObj = new ShopOrderController ();
		
		$_url = $this->_url . 'action=getordersstatus&key=meng&orderno=' . $_num;
		
		$_getRes = Run::getHttpRes ( $_url );
		
		$_getRes = json_decode ( $_getRes, true );
		
		$_n = 0;
		if (empty ( $_getRes )) {
			$this->wlog ( APP_PATH . 'public/log/third_upd_order', '暂无更新数据' );
		} else {
			$_orderExpObj = new ShopOrderExpressModel ();
			
			foreach ( $_getRes as $gk => $gv ) {
				if ($gv ['shipping_status'] == 1) {
					$_d ['oStatus'] = '4';
					//更新订单状态
					$obj->setShopOrder ( $gv ['lydh'], $_d );
					//添加订单操作记录
					$cObj->createOrderHistory ( $gv ['lydh'], $_tmpRes [$gv ['lydh']] ['uId'], '4', '仓库', '财务' );
					
					$dataArray ['oId'] = $gv ['lydh'];
					$dataArray ['expId'] = $gv ['shipping_no'];
					$dataArray ['expName'] = $gv ['shipping_comp'];
					
					$_orderExpObj->addShopOrderExpress ( $dataArray );
					
					++ $_n;
				}
			}
			
			$this->wlog ( APP_PATH . 'public/log/third_upd_order', '更新' . $_n . '条数据' );
		}
	}
	
	/**
	 * 发货JOSN.测试
	 */
	public function createSendOrderJson() {
		
		$_orderId = Run::req('_oid');
		
		$_url = $this->_url . 'action=createsalesorder&key=meng';
		
		$orderRes = $this->getOrder ( $_orderId );
		
		if(empty($orderRes)){
			die('未查询到订单');exit;
		}
		
		$_cityName = '';
		$_pcityName = '';
		if ($orderRes ['city'] == '100001') {
			$_pData ['ckmc'] = '007';
			$_cityName = '北京市';
			$_pcityName = '北京市';
		} elseif ($orderRes ['city'] == '200001') {
			$_pData ['ckmc'] = '001';
			$_cityName = '上海市';
			$_pcityName = '上海市';
		} elseif ($orderRes ['city'] == '300001') {
			$_pData ['ckmc'] = '001';
			$_cityName = '深圳市';
			$_pcityName = '广东省';
		}else{
			$_pData ['ckmc'] = '007';
			$_cityName = '北京市';
			$_pcityName = '北京市';
		}
		/*if ($orderRes ['payCode'] != '') {
			$_pData ['zffs'] = '013';
			$_pData ['zfje'] = $orderRes ['nMoney'];
			$_pData ['rlje'] = $orderRes ['dMoney'];
			$_pData ['jyh'] = $orderRes ['payCode'];
			$_pData ['zfrq'] = $orderRes ['payTime'];
			$_pData ['hdfk'] = '0';
		} else {
			$_pData ['zffs'] = '0000';
			$_pData ['zfje'] = '0';
			$_pData ['rlje'] = '0';
			$_pData ['jyh'] = '';
			$_pData ['zfrq'] = '';
			$_pData ['hdfk'] = '1';
		}*/
		
		$_pData ['lydh'] = $_orderId;
		$_pData ['shr'] = $orderRes ['oName'];
		$_pData ['dizhi'] = $orderRes ['oAddress'];
		$_pData ['shouji'] = $orderRes ['oTel'];
		
		$_pData ['zje'] = $orderRes ['oMoney'];
		$_pData ['rq'] = $orderRes ['createTime'];
		
		$_pData ['sheng'] = $_pcityName;
		$_pData ['shi'] = $_cityName;
		$_pData ['qu'] = '';
		
		$_chilRes = $this->getOrderChil ( $_orderId, $orderRes ['city'] );
		
		$_pData ['row'] = $_chilRes ['spList'];
		$_pData ['zsl'] = $_chilRes ['total'];
		
		$_pData ['zje'] = $_chilRes ['totalPrice'];
		$_pData ['wlfy'] = $orderRes['expMoney'];
		if ($orderRes ['payCode'] != '') {
			$_pData ['zffs'] = '013';
			$_pData ['zfje'] = ($_pData ['zje']-$orderRes ['dMoney'])+$orderRes['expMoney'];//$orderRes ['nMoney'];
			$_pData ['rlje'] = $orderRes ['dMoney'];
			$_pData ['jyh'] = $orderRes ['payCode'];
			$_pData ['zfrq'] = $orderRes ['payTime'];
			$_pData ['hdfk'] = '0';
		} else {
			$_pData ['zffs'] = '0000';
			$_pData ['zfje'] = '0';
			$_pData ['rlje'] = '0';
			$_pData ['jyh'] = '';
			$_pData ['zfrq'] = '';
			$_pData ['hdfk'] = '1';
		}
		
		$_postDataRes = 'inputdata=' .json_encode ( $_pData ); // array ('inputdata' => $_postDataRes )
		
		echo $_postDataRes;exit;
	}
	
	/**
	 * 二次发货
	 */
	public function twoCreateSendOrder() {
		
		$_orderId = Run::req('_oid');
		
		$_url = $this->_url . 'action=createsalesorder&key=meng';
		
		$orderRes = $this->getOrder ( $_orderId );
		$_cityName = '';
		$_pcityName = '';
		if ($orderRes ['city'] == '100001') {
			$_pData ['ckmc'] = '007';
			$_cityName = '北京市';
			$_pcityName = '北京市';
		} elseif ($orderRes ['city'] == '200001') {
			$_pData ['ckmc'] = '001';
			$_cityName = '上海市';
			$_pcityName = '上海市';
		} elseif ($orderRes ['city'] == '300001') {
			$_pData ['ckmc'] = '001';
			$_cityName = '深圳市';
			$_pcityName = '广东省';
		}else{
			$_pData ['ckmc'] = '007';
			$_cityName = '北京市';
			$_pcityName = '北京市';
		}
		/*if ($orderRes ['payCode'] != '') {
			$_pData ['zffs'] = '013';
			$_pData ['zfje'] = $orderRes ['nMoney'];
			$_pData ['rlje'] = $orderRes ['dMoney'];
			$_pData ['jyh'] = $orderRes ['payCode'];
			$_pData ['zfrq'] = $orderRes ['payTime'];
			$_pData ['hdfk'] = '0';
		} else {
			$_pData ['zffs'] = '0000';
			$_pData ['zfje'] = '0';
			$_pData ['rlje'] = '0';
			$_pData ['jyh'] = '';
			$_pData ['zfrq'] = '';
			$_pData ['hdfk'] = '1';
		}*/
		
		$_pData ['lydh'] = $_orderId;
		$_pData ['shr'] = $orderRes ['oName'];
		$_pData ['dizhi'] = $orderRes ['oAddress'];
		$_pData ['shouji'] = $orderRes ['oTel'];
		
		$_pData ['zje'] = $orderRes ['oMoney'];
		$_pData ['rq'] = $orderRes ['createTime'];
		
		$_pData ['sheng'] = $_pcityName;
		$_pData ['shi'] = $_cityName;
		$_pData ['qu'] = '';
		
		$_chilRes = $this->getOrderChil ( $_orderId, $orderRes ['city'] );
		
		$_pData ['row'] = $_chilRes ['spList'];
		$_pData ['zsl'] = $_chilRes ['total'];
		
	
		$_pData ['zje'] = $_chilRes ['totalPrice'];
		$_pData ['wlfy'] = $orderRes['expMoney'];
		if ($orderRes ['payCode'] != '') {
			$_pData ['zffs'] = '013';
			$_pData ['zfje'] = ($_pData ['zje']-$orderRes ['dMoney'])+$orderRes['expMoney'];//$orderRes ['nMoney'];
			$_pData ['rlje'] = $orderRes ['dMoney'];
			$_pData ['jyh'] = $orderRes ['payCode'];
			$_pData ['zfrq'] = $orderRes ['payTime'];
			$_pData ['hdfk'] = '0';
		} else {
			$_pData ['zffs'] = '0000';
			$_pData ['zfje'] = '0';
			$_pData ['rlje'] = '0';
			$_pData ['jyh'] = '';
			$_pData ['zfrq'] = '';
			$_pData ['hdfk'] = '1';
		}
		
		$_postDataRes = json_encode ( $_pData ); //'inputdata=' . array ('inputdata' => $_postDataRes )
		

		//		echo $_postDataRes;
		//		exit ();
		

		$_res = Run::getHttpPostRes ( array ('inputdata' => $_postDataRes ), $_url );
		
		echo ($_res);
		

		$_res = json_decode ( $_res, true );
		
		var_dump($_res);
		
		if ($_res ['code'] == '1') {
			$this->wlog ( APP_PATH . 'public/log/third_send_goods', $_res ['code'] . ' ' . $_res ['message'] . ' ' . $_res ['djbh'] );
		} else {
			$this->wlog ( APP_PATH . 'public/log/third_send_goods', $_res ['code'] . ' ' . $_res ['message'].' '.$_orderId );
		}
	
	}
}