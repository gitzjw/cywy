<?php
final class ShopOrderController extends Base {
	
	//检查用户是否首单
	public function isFirstOrder(){
		$days = date("t");
		$user = $this->getUserDetail ();
		$obj = new ShopOrderModel ();
		$_monthDay = date('Y-m').'-01 00:00:00';
		$_monthEnd = date('Y-m').'-'.$days.' 23:59:59';
		$w = ' uId="' . $user ['id'] . '" and oStatus in ("1","2","4","5","6") and 
			createTime>="'.$_monthDay.'" and createTime<="'.$_monthEnd.'"
		';
		$res = $obj->getShopOrder ( $w, '', '1','1' );
		return $res;
	}
	
	//查询订单列表
	public function getShopOrderList() {
		$user = $this->getUserDetail ();
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page_prev = intval ( $_p ) * 10;
		$limit = $_page_prev . ',' . 10;
		
		$obj = new ShopOrderModel ();
		$res = $obj->getShopOrder ( ' uId="' . $user ['id'] . '" ', '', $limit );
		$newArr = array ();
		if ($res) {
			foreach ( $res as $k => $v ) {
				$_tmpRes = $this->getShopOrderChildrenDetail ( $v ['id'],'4' );
				$newArr [$v ['id']] ['detail'] = $v;
				$newArr [$v ['id']] ['chil'] = $_tmpRes;
			}
			$this->_jsonEn ( '0', $newArr );
		} else {
			$this->_jsonEn ( '609', '暂无更多订单' );
		}
	}
	
	//BD查询订单列表
	public function getShopOrderListBD() {
		
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page_prev = intval ( $_p ) * 10;
		$limit = $_page_prev . ',' . 10;
		
		$_uid = Run::req('_uid');
		
		$obj = new ShopOrderModel ();
		$res = $obj->getShopOrder ( ' uId="' . $_uid . '" ', '' );
		$newArr = array ();
		if ($res) {
			foreach ( $res as $k => $v ) {
				$_tmpRes = $this->getShopOrderChildrenDetail ( $v ['id'],'4' );
				$newArr [$v ['id']] ['detail'] = $v;
				$newArr [$v ['id']] ['chil'] = $_tmpRes;
			}
			$this->_jsonEn ( '0', $newArr );
		} else {
			$this->_jsonEn ( '609', '暂无更多订单' );
		}
	}
	
	//查询全部订单
	public function getShopOrderAdminList() {
		//$user = $this->getUserDetail ();
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page_prev = intval ( $_p ) * 10;
		$limit = $_page_prev . ',' . 10;
		
		$_type = Run::req('type');
		if($_type!='4'){
			$_city = Run::req('city');
			$_w = 'city="'.$_city.'"';
		}else{
			$_w = ' oStatus>=4 ';
		}
		
		
		$obj = new ShopOrderModel ();
		$res = $obj->getShopOrder ( $_w, '', $limit );
		$newArr = array ();
		if ($res) {
			foreach ( $res as $k => $v ) {
				$_tmpRes = $this->getShopOrderChildrenDetail ( $v ['id'],'4' );
				$newArr [$v ['id']] ['detail'] = $v;
				$newArr [$v ['id']] ['chil'] = $_tmpRes;
			}
			$this->_jsonEn ( '0', $newArr );
		} else {
			$this->_jsonEn ( '609', '暂无更多订单' );
		}
	}
	
	//创建订单
	public function cOrder() {
		$_oid = Run::req ( '_oid' );
		if (! $_oid) {
			$obj = new ShopOrderModel ();
			$user = $this->getUserDetail ();
			
			$shopRes = $this->getShopDetail ();
			
			$_isFirstOrder = $this->isFirstOrder();
//			$_isFirstOrder = true;
			
			if($_isFirstOrder){
				$markRes = null;
			}else{
				$markRes = null;//$this->getMarketing ($shopRes ['city']);
			}
			
			$carRes = $this->getCar ();
			
/*			$tsgobj = new ThirdSendGoodsController();
			$_tsgRes = $tsgobj->checkSptm($shopRes ['city'],  $carRes ['car']);
			if(!$_tsgRes['returnRes']){
				$this->_jsonEn ( '504', $_tsgRes['title'].'无货，请重新选择' );
			}*/

			
			if (! $user) {
				$this->_jsonEn ( '504', '用户未登录' );
			}
			
			$_oid = $this->SysOrderId ();
			
			$dataArray ['id'] = $_oid;
			$dataArray ['uId'] = $user ['id'];
			$dataArray ['oName'] = $shopRes ['shopMainName'];
			$dataArray ['oShopName'] = $shopRes ['shopName'];
			$dataArray ['oTel'] = $shopRes ['shopTel'];
			$dataArray ['oAddress'] = $shopRes ['shopAddress'];
			$dataArray ['oMoney'] = $carRes ['totalPrice'];
			$dataArray ['totalNum'] = $carRes ['totalNum'];
			$dataArray ['createTime'] = date ( 'Y-m-d H:i:s' );
			$dataArray ['city'] = $shopRes ['city'];
			$dataArray ['payTime'] = '';
			$dataArray ['payCode'] = '';
			$dataArray ['oStatus'] = '1';
			
			if(empty($dataArray ['totalNum']) || intval($dataArray ['totalNum'])==0){
				$this->_jsonEn('607','订单创建失败');
			}
			
			if (empty ( $markRes )) {
				$dataArray ['dMoney'] = '0';
				$dataArray ['nMoney'] = $carRes ['totalPrice'];
				$dataArray ['oMark'] = '';
			} else {
				foreach ($markRes as $mkk=>$mkv){
					if ($mkv ['wType'] == '1') {
						//满减
						if (floatval ( $carRes ['totalPrice'] ) >= floatval ( $mkv ['money'] )) {
							$dataArray ['dMoney'] = $mkv ['nMoney'];
							$dataArray ['nMoney'] = floatval ( $carRes ['totalPrice'] ) - floatval ( $mkv ['nMoney'] );
							$dataArray ['oMark'] = '';
						}		
					} elseif ($mkv ['wType'] == '2') {
						//满赠
						if (floatval ( $carRes ['totalPrice'] ) >= floatval ( $mkv ['money'] )) {
							$dataArray ['dMoney'] = '0';
							$dataArray ['nMoney'] = $carRes ['totalPrice'];
							$dataArray ['oMark'] = '赠送商品-' . $mkv ['pro'];
						}						
					}
				}
				if(!isset($dataArray['nMoney'])){
					$dataArray ['dMoney'] = '0';
					$dataArray ['nMoney'] = $carRes ['totalPrice'];
					$dataArray ['oMark'] = '';
				}
			}
			//运费强制设置为0，需要时再放开，js中有同样功能代码，shop.goods.d.js
			$_expMoney = '';//$this->findShopOrderExpressMoney(0,$dataArray ['nMoney'],$dataArray ['city']);
			if(empty($_expMoney)){
				$dataArray['expMoney']='0.00';
			}else{
				$dataArray['expMoney']=$_expMoney['exp_money'];
				$dataArray ['nMoney'] = floatval($dataArray ['nMoney'])+floatval($dataArray['expMoney']);
			}			
			$res = $obj->addShopOrder ( $dataArray );
			if ($res) {
				$_codRes = $this->createOrderDetail ( $_oid, $user ['id'], $carRes ['car'] );
				if(floatval($_codRes['totalPrice'])!=$dataArray['oMoney']){
					$_tmpDataArray ['oMoney'] = floatval($_codRes['totalPrice']);
					$_tmpDataArray ['nMoney'] = floatval ( $_tmpDataArray ['oMoney'] ) - floatval ( $dataArray ['dMoney'] );
					if(empty($_expMoney)){
						$_tmpDataArray ['expMoney'] = '0.00';
					}else{
						$_tmpDataArray ['expMoney'] = $_expMoney['exp_money'];
						$_tmpDataArray ['nMoney'] = floatval($_tmpDataArray ['nMoney'])+floatval($_tmpDataArray['expMoney']);
					}
					$obj->setShopOrder($_oid, $_tmpDataArray);
				}
				
				//创建赠品
				if($_isFirstOrder){
					
				}else{
					$this->createOrderDetailMarketing($_oid,  $user ['id'], $_codRes['totalPrice']);
				}
				
				$this->createOrderHistory ( $_oid, $user ['id'],'1','系统','客服' );
				
				//推送给采购人员
//				$this->sendCgSpe($_oid,$dataArray);
				
				//创建发货订单
				$_tmpObj = new ThirdSendGoodsController();
				$_tmpObj->createSendOrder($_oid);
				
				//清空购物车
				$_shopName = 'shopCar';
				$obj = new ParamsController ();
				$obj->localSetParams ( $_shopName, null );
				$obj->localSetParams ( 'shopLeftCarNum', null );
				
				$payRes ['_oid'] = $_oid;
				$payRes ['msg'] = '创建订单成功';
				$this->_jsonEn ( '1', $payRes );
			} else {
				$this->_jsonEn ( '607', '创建订单失败' );
			}
		}
		/*
		$payRes = $this->pay ( $_oid );
		if ($payRes) {
			$payRes ['_oid'] = $_oid;
			$this->_jsonEn ( '1', $payRes );
		} else {
			$this->_jsonEn ( '502', '支付请求失败' );
		}
		*/
	}
	
	//创建订单 带支付
	public function cOrderPay() {
		$_oid = Run::req ( '_oid' );
		if (! $_oid) {
			$obj = new ShopOrderModel ();
			$user = $this->getUserDetail ();
			
			$shopRes = $this->getShopDetail ();
			
			$_isFirstOrder = $this->isFirstOrder();
			
			if($_isFirstOrder){
				$markRes = null;
			}else{
				$markRes = $this->getMarketing ($shopRes ['city']);
			}
			
			$carRes = $this->getCar ();
			
			/*$tsgobj = new ThirdSendGoodsController();
			$_tsgRes = $tsgobj->checkSptm($shopRes ['city'],  $carRes ['car']);
			if(!$_tsgRes['returnRes']){
				$this->_jsonEn ( '504', $_tsgRes['title'].'无货，请重新选择' );
			}*/
			
			
			if (! $user) {
				$this->_jsonEn ( '504', '用户未登录' );
			}
			
			$_oid = $this->SysOrderId ();
			
			$dataArray ['id'] = $_oid;
			$dataArray ['uId'] = $user ['id'];
			$dataArray ['oName'] = $shopRes ['shopMainName'];
			$dataArray ['oShopName'] = $shopRes ['shopName'];
			$dataArray ['oTel'] = $shopRes ['shopTel'];
			$dataArray ['oAddress'] = $shopRes ['shopAddress'];
			$dataArray ['oMoney'] = $carRes ['totalPrice'];
			$dataArray ['totalNum'] = $carRes ['totalNum'];
			$dataArray ['createTime'] = date ( 'Y-m-d H:i:s' );
			$dataArray ['city'] = $shopRes ['city'];
			$dataArray ['payTime'] = '2000-01-01';
			$dataArray ['payCode'] = '';
			$dataArray ['oStatus'] = '1';
			
			if(empty($dataArray ['totalNum']) || intval($dataArray ['totalNum'])==0){
				$this->_jsonEn('607','订单创建失败');
			}
			
			if (empty ( $markRes )) {
				$dataArray ['dMoney'] = '0';
				$dataArray ['nMoney'] = $carRes ['totalPrice'];
				$dataArray ['oMark'] = '';
			} else {
				$dataArray ['dMoney'] = '0';
				$dataArray ['nMoney'] = $carRes ['totalPrice'];
				$dataArray ['oMark'] = '';
				foreach ($markRes as $mkk=>$mkv){
					if ($mkv ['wType'] == '1') {
						//满减
						if (floatval ( $carRes ['totalPrice'] ) >= floatval ( $mkv ['money'] )) {
							$dataArray ['dMoney'] = $mkv ['nMoney'];
							$dataArray ['nMoney'] = floatval ( $carRes ['totalPrice'] ) - floatval ( $mkv ['nMoney'] );
							$dataArray ['oMark'] = '';
						}		
					}
					/*
					elseif ($mkv ['wType'] == '2') {
						//满赠
						if (floatval ( $carRes ['totalPrice'] ) >= floatval ( $mkv ['money'] )) {
							$dataArray ['dMoney'] = '0';
							$dataArray ['nMoney'] = $carRes ['totalPrice'];
							$dataArray ['oMark'] = '赠送商品-' . $mkv ['pro'];
						}						
					}
					*/
				}
				if(!isset($dataArray['nMoney'])){
					$dataArray ['dMoney'] = '0';
					$dataArray ['nMoney'] = $carRes ['totalPrice'];
					$dataArray ['oMark'] = '';
				}
			}
			$_expMoney = '';$this->findShopOrderExpressMoney(0,$dataArray ['nMoney'],$dataArray ['city']);
			if(empty($_expMoney)){
				$dataArray['expMoney']='0.00';
			}else{
				$dataArray ['expMoney'] =$_expMoney['exp_money'];
				$dataArray ['nMoney'] = floatval($dataArray ['nMoney'])+floatval($dataArray['expMoney']);
			}
			$res = $obj->addShopOrder ( $dataArray );
			if ($res) {				
				$_codRes = $this->createOrderDetail ( $_oid, $user ['id'], $carRes ['car'] );
				if(floatval($_codRes['totalPrice'])!=$dataArray['oMoney']){
					$_tmpDataArray ['oMoney'] = floatval($_codRes['totalPrice']);
					$_tmpDataArray ['nMoney'] = floatval ( $_tmpDataArray ['oMoney'] ) - floatval ( $dataArray ['dMoney'] );
					if(empty($_expMoney)){
						$_tmpDataArray ['expMoney'] = '0.00';
					}else{
						$_tmpDataArray ['expMoney'] = $_expMoney['exp_money'];
						$_tmpDataArray ['nMoney'] = floatval($_tmpDataArray ['nMoney'])+floatval($_tmpDataArray['expMoney']);
					}
					$obj->setShopOrder($_oid, $_tmpDataArray);
				}
				//创建赠品
				if($_isFirstOrder){
					
				}else{
					$this->createOrderDetailMarketing($_oid,  $user ['id'], $_codRes['totalPrice']);
				}				
				
				$this->createOrderHistory ( $_oid, $user ['id'],'1','系统','客服' );
				
				//推送给采购人员
//				$this->sendCgSpe($_oid,$dataArray);
				
				//清空购物车
				$_shopName = 'shopCar';
				$obj = new ParamsController ();
				$obj->localSetParams ( $_shopName, null );
				$obj->localSetParams ( 'shopLeftCarNum', null );
				$payRes = $this->pay ( $_oid );
				$payRes ['_oid'] = $_oid;
				$payRes ['msg'] = '创建订单成功';
				$this->_jsonEn ( '1', $payRes );
			} else {
				$this->_jsonEn ( '607', '创建订单失败' );
			}
		}
		
		$payRes = $this->pay ( $_oid );
		if ($payRes) {
			$payRes ['_oid'] = $_oid;
			$this->_jsonEn ( '1', $payRes );
		} else {
			$this->_jsonEn ( '502', '支付请求失败' );
		}
		
	}
	
	//创建订单 活动带支付
	public function cOrderActPay() {
		$_oid = Run::req ( '_oid' );
		if (! $_oid) {
			$obj = new ShopOrderModel ();
			$user = $this->getUserDetail ();
			
			$shopRes = $this->getShopDetail ();
			
			$_isFirstOrder = true;
			
			if($_isFirstOrder){
				$markRes = null;
			}else{
				$markRes = $this->getMarketing ($shopRes ['city']);
			}
			
			$carRes = $this->getCar ();
			
			if (! $user) {
				$this->_jsonEn ( '504', '用户未登录' );
			}
			
			$_oid = $this->SysOrderId ();
			
			$dataArray ['id'] = $_oid;
			$dataArray ['uId'] = $user ['id'];
			$dataArray ['oName'] = $shopRes ['shopMainName'];
			$dataArray ['oShopName'] = $shopRes ['shopName'];
			$dataArray ['oTel'] = $shopRes ['shopTel'];
			$dataArray ['oAddress'] = $shopRes ['shopAddress'];
			$dataArray ['oMoney'] = $carRes ['totalOPrice'];
			$dataArray ['totalNum'] = $carRes ['totalNum'];
			$dataArray ['createTime'] = date ( 'Y-m-d H:i:s' );
			$dataArray ['city'] = $shopRes ['city'];
			$dataArray ['payTime'] = '';
			$dataArray ['payCode'] = '';
			$dataArray ['oStatus'] = '1';
			
			if(empty($dataArray ['totalNum']) || intval($dataArray ['totalNum'])==0){
				$this->_jsonEn('607','订单创建失败');
			}
			
			if (empty ( $markRes )) {
				$dataArray ['dMoney'] = floatval($carRes ['totalOPrice'])-floatval($carRes ['totalPrice']);
				$dataArray ['nMoney'] = $carRes ['totalPrice'];
				$dataArray ['oMark'] = '';
			} else {
				$dataArray ['dMoney'] = '0';
				$dataArray ['nMoney'] = $carRes ['totalPrice'];
				$dataArray ['oMark'] = '';
				foreach ($markRes as $mkk=>$mkv){
					if ($mkv ['wType'] == '1') {
						//满减
						if (floatval ( $carRes ['totalPrice'] ) >= floatval ( $mkv ['money'] )) {
							$dataArray ['dMoney'] = $mkv ['nMoney'];
							$dataArray ['nMoney'] = floatval ( $carRes ['totalPrice'] ) - floatval ( $mkv ['nMoney'] );
							$dataArray ['oMark'] = '';
						}		
					} elseif ($mkv ['wType'] == '2') {
						//满赠
						if (floatval ( $carRes ['totalPrice'] ) >= floatval ( $mkv ['money'] )) {
							$dataArray ['dMoney'] = '0';
							$dataArray ['nMoney'] = $carRes ['totalPrice'];
							$dataArray ['oMark'] = '赠送商品-' . $mkv ['pro'];
						}						
					}
				}
				if(!isset($dataArray['nMoney'])){
					$dataArray ['dMoney'] = '0';
					$dataArray ['nMoney'] = $carRes ['totalPrice'];
					$dataArray ['oMark'] = '';
				}
			}
			
			$res = $obj->addShopOrder ( $dataArray );
			if ($res) {
				$_codRes = $this->createOrderDetail ( $_oid, $user ['id'], $carRes ['car'] );
				if(floatval($_codRes['totalPrice'])!=$dataArray['oMoney']){
					$_tmpDataArray ['oMoney'] = floatval($_codRes['totalPrice']);
					$_tmpDataArray ['nMoney'] = floatval ( $_tmpDataArray ['oMoney'] ) - floatval ( $dataArray ['dMoney'] );
					$obj->setShopOrder($_oid, $_tmpDataArray);
				}
				$this->createOrderHistory ( $_oid, $user ['id'] );
				
				//推送给采购人员
//				$this->sendCgSpe($_oid,$dataArray);
				
				//清空购物车
				$_shopName = 'shopCar';
				$obj = new ParamsController ();
				$obj->localSetParams ( $_shopName, null );
				$obj->localSetParams ( 'shopLeftCarNum', null );
				$payRes = $this->pay ( $_oid );
				$payRes ['_oid'] = $_oid;
				$payRes ['msg'] = '创建订单成功';
				$this->_jsonEn ( '1', $payRes );
			} else {
				$this->_jsonEn ( '607', '创建订单失败' );
			}
		}
		
		$payRes = $this->pay ( $_oid );
		if ($payRes) {
			$payRes ['_oid'] = $_oid;
			$this->_jsonEn ( '1', $payRes );
		} else {
			$this->_jsonEn ( '502', '支付请求失败' );
		}
		
	}
	
	private function sendCgSpe($oid,$_od){
		$obj = new ShopSpeUserController();
		$res = $obj->getShopSpeUserWtype('2',$_od['city']);
		if(empty($res)){
			return false;
		}else{
			$cdate = date("Y-m-d H:i");
			$_descp = htmlspecialchars('收货人：'.$_od['oName'].'\n\r联系方式：'.$_od['oTel'].'\n\r收货地址：'.$_od['oAddress'].'\n\r');
			foreach ($res as $k=>$v){
				$str = '{
				    "touser":"'.$v['openid'].'",
				    "msgtype":"news",
				    "news":{
				        "articles": [
				         {
				             "title":"'.$cdate.' 的订单",
				             "description":"'.$_descp.'",
				             "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9100a963fadb1a80&redirect_uri=http%3A%2F%2Fweb.chongyewuyou.com%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.order.detail.admin%26i%3D'.$oid.'&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect",
				             "picurl":""
				         }
				         ]
				    }
				}';
				$res = WechatToken::_sendWechatCustom($str);
				//$this->wlog(APP_PATH.'public/log/cg-spe.log',json_encode($res));
			}
		}
		return true;
	}
	
	//得到商家信息
	private function getShopDetail() {
		$shopObj = new CakeShopController ();
		$shopRes = $shopObj->getCakeShopUid ();
		return $shopRes;
	}
	
	//得到优惠信息
	private function getMarketing($city='') {
		$obj = new ShopMarketingController ();
		$_currentDate = date ( 'Y-m-d' );
		$w = ' sTime<="' . $_currentDate . '" and eTime>="' . $_currentDate . '" and city="'.$city.'" ';
		$obj = new ShopMarketingModel ();
		$res = $obj->getShopMarketing ( $w, 'money', '' );
		return $res;
	}
	
	//创建订单详情
	public function createOrderDetail($_oid, $_uid, $_car) {
		$_arr['totalPrice'] = 0;
		$_arr['totalNum'] = 0;
		$obj = new ShopOrderDetailModel ();
		foreach ( $_car as $k => $v ) {
			if(isset($v['0']) && !empty($v['0'])){
				$dataArray ['oId'] = $_oid;
				$dataArray ['uId'] = $_uid;
				$dataArray ['pId'] = $v ['0'];
				$dataArray ['pTitle'] = $v ['2'];
				$dataArray ['eNum'] = $v ['3'];
				$dataArray ['ePrice'] = $v ['1'];
//				$dataArray ['tPrice'] = $v ['4'];
				$dataArray ['tPrice'] = intval($dataArray ['eNum'])*floatval($dataArray ['ePrice']);
				$dataArray ['odStatus'] = '1';
				$res = $obj->addShopOrderDetail ( $dataArray );
				$_arr['totalPrice'] += intval($dataArray ['eNum'])*floatval($dataArray ['ePrice']);
				$_arr['totalNum'] += $dataArray ['eNum'];
			}
		}
		return $_arr;
	}
	
	//创建订单详情-赠品
	public function createOrderDetailMarketing($_oid,$_uid,$_m){
		$obj = new ShopMarketingController();
		$res = $obj->getShopMarketingPro(0,$_m);
//		var_dump($res);
		if(!$res){
			return false;
		}else{
			$obj = new ShopOrderDetailModel ();
			foreach ($res as $k=>$v){
				$dataArray ['oId'] = $_oid;
				$dataArray ['uId'] = $_uid;
				$dataArray ['pId'] = $v ['id'];
				$dataArray ['pTitle'] = $v ['title'];
				$dataArray ['eNum'] = $v ['num'];
				$dataArray ['ePrice'] = '0.00';
				$dataArray ['tPrice'] = '0.00';
				$dataArray ['odStatus'] = '1';
				$obj->addShopOrderDetail ( $dataArray );
			}
		}
	}
	
	//创建订单操作记录
	public function createOrderHistory($_oid, $_uid, $_s = '1', $oUser = '系统', $rUser = '系统') {
		$obj = new ShopOrderHistoryModel ();
		$dataArray ['uId'] = $_uid;
		$dataArray ['oId'] = $_oid;
		$dataArray ['oStatus'] = $_s;
		$dataArray ['oUser'] = $oUser;
		$dataArray ['rUser'] = $rUser;
		$dataArray ['createTime'] = date ( 'Y-m-d H:i:s' );
		$res = $obj->addShopOrderHistory ( $dataArray );
		return $res;
	}
	
	//购物车内容
	public function getCar() {
		$obj = new ParamsController ();
		$_shopName = 'shopCar';
		$_tmpArr = $obj->getSessionParams ( $_shopName );
		if (empty ( $_tmpArr )) {
			$this->_jsonEn ( '606', '创建订单失败，未发现所购物品' );
		}
		return $_tmpArr;
	}
	
	//查询订单详情
	public function getShopOrderDetail($_oid) {
		$obj = new ShopOrderModel ();
		$w = 'id="' . $_oid . '"';
		$res = $obj->getShopOrder ( $w, '', '', '1' );
		return $res;
	}
	
	//查询子订单详情
	public function getShopOrderChildrenDetail($_oid,$limit='') {
		$obj = new ShopOrderDetailModel ();
		$w = 'oId="' . $_oid . '"';
		$res = $obj->getShopOrderDetail ( $w,'',$limit );
		return $res;
	}
	
	//查询操作记录详情
	public function getShopOrderHistoryDetail($_oid) {
		$obj = new ShopOrderHistoryModel ();
		$w = 'oId="' . $_oid . '"';
		$res = $obj->getShopOrderHistory ( $w );
		return $res;
	}
	
	/**
	 * 
	 * 支付成功回调
	 */
	public function payCallBack($params) {
		$res = json_decode ( json_encode ( simplexml_load_string ( $params, 'SimpleXMLElement', LIBXML_NOCDATA ) ), true );
		$saveRes = null;
		if ($res ['return_code'] == 'SUCCESS') {
			$obj = new ShopOrderModel ();
			$orderRes = $obj->getShopOrder ( 'id="' . $res ['out_trade_no'] . '"', '', '', '1' );
			if (empty ( $orderRes )) {
			
			} else {
				$orderRes ['payTime'] = date ( 'Y-m-d H:i:s' );
				$orderRes ['payCode'] = $res ['transaction_id'];
				if ($orderRes ['oStatus'] == '1') {
					$orderRes ['oStatus'] = '2';
					//更新支付订单
					$saveRes = $obj->setShopOrder ( $res ['out_trade_no'], $orderRes );
					//添加订单操作记录
					$this->createOrderHistory ( $res ['out_trade_no'], $orderRes ['uId'], '2','客服','仓库' );
					
					//创建发货订单
					$_tmpObj = new ThirdSendGoodsController();
					$_tmpObj->createSendOrder($res ['out_trade_no']);
					
					//确认通知用户
					$this->sendUserMsg($orderRes['uId'], $res ['out_trade_no'],'1');
					
					echo '<xml>
						  <return_code><![CDATA[SUCCESS]]></return_code>
						  <return_msg><![CDATA[OK]]></return_msg>
						</xml>';
				}
			}
		} else {
		
		}
	}
	
	/**
	 * 微信创建虚拟订单-返回sign标识，用于客户端支付
	 */
	public function pay($orderid) {
		$parObj = new ParamsController ();
		$openid = $parObj->getSessionParams ( 'openid' );
		
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$callBackUrl = APP_WEBSITE . 'c/ShopOrderPayCallback.php';
		$ip = $this->_getIp ();
		$rndStr = strtoupper ( $this->getRandomString ( 32, '3' ) );
		$payTitle = '宠业无忧在线支付';
		
		$res = $this->getShopOrderDetail ( $orderid );
		
		if (! $res) {
			return false;
		}
		
		$totalPrice = floatval ( $res ['nMoney'] ) * 100;
		
		$kD ['appid'] = APPID;
		$kD ['attach'] = 'JSAPI';
		$kD ['body'] = $payTitle;
		$kD ['mch_id'] = APP_MCH_ID;
		$kD ['nonce_str'] = $rndStr;
		$kD ['notify_url'] = $callBackUrl;
		$kD ['openid'] = $openid;
		$kD ['out_trade_no'] = $orderid;
		$kD ['spbill_create_ip'] = $ip;
		$kD ['total_fee'] = $totalPrice;
		$kD ['trade_type'] = 'JSAPI';
		ksort ( $kD );
		$strSignTmp = '';
		foreach ( $kD as $kk => $vv ) {
			$strSignTmp .= $kk . '=' . $vv . '&';
		}
		$strSignTmp .= 'key=zVFr2VbLjPNaVKnSMqYGj3utbYXfRRhQ';
		$sign = strtoupper ( md5 ( $strSignTmp ) );
		
		$strXml = "<xml>
				   <appid>{$kD['appid']}</appid>
				   <attach>JSAPI</attach>
				   <body>{$payTitle}</body>
				   <mch_id>{$kD['mch_id']}</mch_id>
				   <nonce_str>{$rndStr}</nonce_str>
				   <notify_url>{$callBackUrl}</notify_url>
				   <openid>{$openid}</openid>
				   <out_trade_no>{$orderid}</out_trade_no>
				   <spbill_create_ip>{$ip}</spbill_create_ip>
				   <total_fee>{$totalPrice}</total_fee>
				   <trade_type>JSAPI</trade_type>
				   <sign>{$sign}</sign>
				</xml>";
		
		$res = Run::getHttpPostRes ( $strXml, $url );
		$res = json_decode ( json_encode ( simplexml_load_string ( $res, 'SimpleXMLElement', LIBXML_NOCDATA ) ), true );
		$startResult = $this->_startJsApiSign ( $res );
		if ($startResult != false) {
			$res ['newSign'] = $startResult ['sign'];
			$res ['timestamp'] = $startResult ['timestamp'];
			$res ['newRndstr'] = $startResult ['rndstr'];
		
		//$res['str']=$startResult['str'];
		}
		return $res;
	}
	
	//客户端JSAPI发起支付的验证签名
	private function _startJsApiSign($res) {
		if ($res ['return_code'] == 'SUCCESS') {
			$rndStr = strtoupper ( $this->getRandomString ( 32, '3' ) );
			$arr = array ('appId' => $res ['appid'], 'timeStamp' => time (), 'nonceStr' => $rndStr, 'package' => 'prepay_id=' . $res ['prepay_id'], 'signType' => 'MD5' );
			ksort ( $arr );
			$str = '';
			foreach ( $arr as $k => $v ) {
				$str .= $k . '=' . $v . '&';
			}
			$str .= 'key=zVFr2VbLjPNaVKnSMqYGj3utbYXfRRhQ';
			//$res['str']=$str;
			$res ['sign'] = strtoupper ( md5 ( $str ) );
			$res ['timestamp'] = strval ( $arr ['timeStamp'] );
			$res ['rndstr'] = $rndStr;
		} else {
			$res = false;
		}
		return $res;
	}
	
	//确认订单
	public function yesOrderStatus() {
		$_s = Run::req('_s');
		//查询订单详情
		$_oid = Run::req('_oid');
		$orderRes = $this->getShopOrderDetail($_oid);
		
		//添加操作订单历史记录	
		$speRes = $this->getSpeUserDetail();	
		if($_s=='1'){
			$this->createOrderHistory($_oid, $orderRes['uId'],'2',$speRes['sName'],$speRes['sName']);
			$this->updateOrderStatus($_oid,'2');
			//确认通知用户
			$this->sendUserMsg($orderRes['uId'], $_oid,'1');
			
		}elseif($_s=='2'){
			$speCFORes = $this->_getSpeUserCFO();
			$this->createOrderHistory($_oid, $orderRes['uId'],'4',$speRes['sName'],$speCFORes['sName']);
			//推送给财务专员
			$this->sendCFOSpe($_oid);
			
			$this->updateOrderStatus($_oid,'4');
		}elseif($_s=='4'){
			$this->createOrderHistory($_oid, $orderRes['uId'],'5',$speRes['sName'],'系统');
			$this->updateOrderStatus($_oid,'5');
		}elseif($_s=='5'){
			$this->createOrderHistory($_oid, $orderRes['uId'],'6',$speRes['sName'],'系统');
			$this->updateOrderStatus($_oid,'6');
		}
		
		$this->_jsonEn('1','操作成功');
		
	}
	
	//推送给财务
	private function sendCFOSpe($oid){
		$obj = new ShopSpeUserController();
		$res = $obj->getShopSpeUserWtype('4');
		if(empty($res)){
			return false;
		}else{
			$cdate = date("Y-m-d H:i");
			foreach ($res as $k=>$v){
				$str = '{
				    "touser":"'.$v['openid'].'",
				    "msgtype":"news",
				    "news":{
				        "articles": [
				         {
				             "title":"'.$cdate.' 的订单",
				             "description":"点击查看订单",
				             "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9100a963fadb1a80&redirect_uri=http%3A%2F%2Fweb.chongyewuyou.com%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.order.detail.admin%26i%3D'.$oid.'&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect",
				             "picurl":""
				         }
				         ]
				    }
				}';
				$res = WechatToken::_sendWechatCustom($str);
			}
		}
		return true;
	}
	
	//更新订单状态 执行
	public function updateOrderStatus($_oid='',$_s=''){
		if(!$_oid){
			return false;
		}
		if(!$_s){
			return false;
		}
		$obj = new ShopOrderModel();
		$dataArray['oStatus']=$_s;
		$res = $obj->setShopOrder($_oid, $dataArray);
		return $res;
	}
	
	//取消订单
	public function quitOrder() {
		//查询订单详情
		$_oid = Run::req('_oid');
		$orderRes = $this->getShopOrderDetail($_oid);
		
		//添加操作订单历史记录
		$speRes = $this->getSpeUserDetail();
		$this->createOrderHistory($_oid, $orderRes['uId'],'3',$speRes['sName'],'系统');
		$this->updateOrderStatus($_oid,'3');
		//取消通知用户
		$this->sendUserMsg($orderRes['uId'], $_oid,'2');
		
		$_num = Run::req('_num');
		$_num = intval($_num);
		for($i=1;$i<=$_num;$i++){
			$_tmpStr = Run::req('data'.$i);
			
			$_tmpData = explode('@', $_tmpStr);
			//更新订单详情状态
			$this->updateOrderDetailStatus($_tmpData[0],'2');
			//更新物品状态
			//$this->updateShopPro($_tmpData[1],'1',$orderRes['city']);
		}
		
		$this->_jsonEn('1','取消成功');
	}
	
	//支付失败
	public function payFail(){
		//查询订单详情
		$_oid = Run::req('_oid');
		$orderRes = $this->getShopOrderDetail($_oid);
		
		//添加操作订单历史记录
		$speRes = $this->getSpeUserDetail();
		$this->createOrderHistory($_oid, $orderRes['uId'],'3','系统','系统');
		$this->updateOrderStatus($_oid,'3');
		
		$this->_jsonEn('1','自动取消成功');
	}
	
	//查询绑定的专员
	public function getSpeUserDetail(){
		$speUserObj = new ShopSpeUserController();
		$user = $this->getUserDetail();
		$speRes = $speUserObj->checkUid($user['id'],new ShopSpeUserModel());
		if($speRes){
			return $speRes;
		}else{
			return array('sName'=>'系统');
		}
	}
	
	//查询财务专员
	public function _getSpeUserCFO(){
		$obj = new ShopSpeUserModel();
		$w = 'wType="4"';
		$res = $obj->getShopSpeUser($w,'','1','1');
		if(empty($res)){
			return array('sName'=>'系统');
		}else{
			return $res;
		}
	}
	
	//更新订单详情里的某个记录的状态
	private function updateOrderDetailStatus($_id='',$_s = '1') {
		if(!$_id){
			return false;
		}
		$obj = new ShopOrderDetailModel();
		$dataArray['odStatus'] = '2';
		$res = $obj->setShopOrderDetail($_id, $dataArray);
		return $res;
	}
	
	//更新商品信息 
	private function updateShopPro($pid = '',$_s = '1',$_tab='') {
		$_id = $pid;
		if (! $_id) {
			return false;
		}
		$obj = new ShopProModel ();
		$obj->setTableCity($_tab);
		if ($_s == '1') {
			$data ['spStatus'] = '2';
			$res = $obj->setShopPro ( $_id, $data );
		} else {
			/*$data ['sNum'] = '';
			$data ['nNum'] = '';
			$res = $obj->setShopPro ( $_id, $data );*/
		}
		return $res;
	}
	
	//推送给用户
	public function sendUserMsg($uid,$oid,$_s='1'){
		$obj = new UsersModel();
		$res = $obj->getUsers('id="'.$uid.'"','','1','1');
		if(empty($res)){
			return false;
		}else{
			if($_s=='1'){
				$str = '{
				    "touser":"'.$res['openId'].'",
				    "msgtype":"news",
				    "news":{
				        "articles": [
				         {
				             "title":"您的订单已经确认",
				             "description":"点击查看订单",
				             "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9100a963fadb1a80&redirect_uri=http%3A%2F%2Fweb.chongyewuyou.com%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.order.detail%26i%3D'.$oid.'&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect",
				             "picurl":""
				         }
				         ]
				    }
				}';
			}else{
				$str = '{
				    "touser":"'.$res['openId'].'",
				    "msgtype":"news",
				    "news":{
				        "articles": [
				         {
				             "title":"您的订单已经被取消",
				             "description":"点击查看原因，并且重新下单",
				             "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9100a963fadb1a80&redirect_uri=http%3A%2F%2Fweb.chongyewuyou.com%2Fe%2Fwechat%2Fwechat.callback.nologin.php%3Ftpl%3Dshop.php%3Ftpl%3Dv1.shop.order.detail%26i%3D'.$oid.'&response_type=code&scope=snsapi_base&state=mmd#wechat_redirect",
				             "picurl":""
				         }
				         ]
				    }
				}';
			}			
			$res = WechatToken::_sendWechatCustom($str);
		}
		return true;
	}
	
	//重新下单
	public function replayCreateOrder(){
		$_oid = Run::req('i');
		$_orderDetail = $this->getShopOrderDetail($_oid);
		$_orderChilRes = $this->getShopOrderChildrenDetail($_oid);
		$_d['car'] = array();
		$_d['totalNum'] = 0;
		$_d['totalPrice'] = 0;
		$_leftD['leftcar'] = array();
		$spoObj = new ShopProModel();
		foreach ($_orderChilRes as $k=>$v){
			if($v['odStatus']=='1'){

				if(intval($v['ePrice']) === 0){
					continue;
				}

				$_wtypeRes = $this->_getShopProWtype($v['pId'], $spoObj,$_orderDetail['city']);
				if(isset($_leftD['leftcar'][$_wtypeRes['wType']])){
					$_leftD['leftcar'][$_wtypeRes['wType']] = intval($_leftD['leftcar'][$_wtypeRes['wType']])+intval($v['eNum']);
				}else{
					$_leftD['leftcar'][$_wtypeRes['wType']] = intval($v['eNum']);
				}
				$_d['car'][$v['pId']]['0'] = $v['pId'];
				$_d['car'][$v['pId']]['1'] = $v['ePrice'];
				$_d['car'][$v['pId']]['2'] = $v['pTitle'];
				$_d['car'][$v['pId']]['3'] = $v['eNum'];
				$_d['car'][$v['pId']]['4'] = intval($v['tPrice']);
				$_d['totalNum'] = intval($_d['totalNum'])+intval($v['eNum']);
				$_d['totalPrice'] = intval($_d['totalPrice'])+intval($v['tPrice']);
			}
		}
		$obj = new ParamsController();
		$_shopName = 'shopCar';
		$obj->localSetParams ( $_shopName, $_d );
		$_shopName = 'shopLeftCarNum';
		$obj->localSetParams ( $_shopName, $_leftD );
		$this->_jsonEn('1','');
	}
	
	private function _getShopProWtype($_pid,$spoObj,$_tab=''){
		$spoObj->setTableCity($_tab);
		$spoObj->setField('wType');
		$res = $spoObj->getShopPro('id="'.$_pid.'"','','1','1');
		return $res;
	}
	
	public function getStatusDesc($_s){
		$_str = '';
		switch ($_s) {
			case '1' :
				$_str = '<b style="color:C0C0C0">订单创建成功</b>';
				break;
			case '2' :
				$_str = '<b style="color:#DAA520">订单已确认，待配送</b>';
				break;
			case '3' :
				$_str = '<b style="color:#696969">订单已取消</b>';
				break;
			case '4' :
				$_str = '<b style="color:#D2691E">订单配送中</b>';
				break;
			case '5' :
				$_str = '<b style="color:#00FF00">收款成功</b>';
				break;
			case '6' :
				$_str = '<b style="color:#008000">订单已完成</b>';
				break;
			case '7' :
				$_str = '<b style="color:#FF0000">退货申请中</b>';
				break;
			case '8' :
				$_str = '<b style="color:#B22222">退货成功</b>';
				break;
			default :
				$_str = '<b style="color:#90EE90">订单创建成功</b>';
				break;
		}
		return $_str;
	}
	
	/**
	 * 查询配送费
	 */
	public function findShopOrderExpressMoney($_returnRes=1,$_m=0,$_city=0){	
		$obj = new ShopOrderExpressMoneyModel();
		if($_returnRes){
			$_m = Run::req('_m');
		}else{
			
		}
		
		if($_returnRes){
			$_city = Run::req('city');
		}else{
			
		}
		
		$w = ' money<="'.$_m.'" and exp_status="1" and city="'.$_city.'" ';
		$res = $obj->getShopOrderExpressMoney($w,' money desc ','1','1');
		
		if(!$_returnRes){
			return $res;
		}else{
			if($res){
				$this->_jsonEn('1',$res);
			}else{
				$this->_jsonEn('701','未找到匹配的配送费');
			}			
		}
		
	} 
}