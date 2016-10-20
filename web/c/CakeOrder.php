<?php
final class CakeOrderController extends Base {
	
	//查询用户的订单
	public function getCakeOrderUid() {
		$user = $this->getUserDetail ();
		
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page_prev = intval ( $_p ) * 10;
		$limit = $_page_prev . ',' . 10;
		
		$obj = new CakeOrderModel ();
		$res = $obj->getCakeOrder ( ' uId="' . $user ['id'] . '" and status>="2" ', '', $limit );
		if ($res) {
			$this->_jsonEn ( '0', $res );
		} else {
			$this->_jsonEn ( '501', '暂无更多订单' );
		}
	}
	
	public function getCakeOrderIncome() {
		$user = $this->getUserDetail ();
		
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page_prev = intval ( $_p ) * 10;
		$limit = $_page_prev . ',' . 10;
		
		$obj = new CakeOrderModel ();
		$res = $obj->getCakeOrder ( ' uId="' . $user ['id'] . '" and status>="2" ', '', $limit );
		$obj->setField ( ' sum(payMoney) as total ' );
		$totalRes = $obj->getCakeOrder ( ' uId="' . $user ['id'] . '" and status>="2" ', '', '', '1' );
		$_enRes ['res'] = $res;
		$_enRes ['total'] = $totalRes ['total'];
		if ($res) {
			$this->_jsonEn ( '0', $_enRes );
		} else {
			$this->_jsonEn ( '501', '暂无更多订单' );
		}
	}
	
	public function getCakeOrderId($id) {
		$obj = new CakeOrderModel ();
		$res = $obj->getCakeOrder ( ' id="' . $id . '" ', '', '1', '1' );
		return $res;
	}
	
	public function getStatusText($val) {
		$_str = '';
		switch ($val) {
			case '1' :
				$_str = '已创建';
				break;
			case '2' :
				$_str = '已支付';
				break;
			case '3' :
				$_str = '配送中';
				break;
			case '4' :
				$_str = '退款';
				break;
			case '5' :
				$_str = '退货';
				break;
			case '9' :
				$_str = '完成';
				break;
			default :
				$_str = '已创建';
				break;
		}
		return $_str;
	}
	
	public function cOrder() {
		$this->_jsonEn ( '504', '系统升级中...' );
		$_oid = Run::req ( '_oid' );
		if (! $_oid) {
			$obj = new CakeOrderModel ();
			$user = $this->getUserDetail ();
			if (! $user) {
				$this->_jsonEn ( '504', '' );
			}
			
			$_oid = $this->SysOrderId ();
			
			$dataArray ['id'] = $_oid;
			$dataArray ['uId'] = $user ['id'];
			$dataArray ['cpId'] = Run::req ( 'cpid' );
			if (empty ( $dataArray ['cpId'] )) {
				$this->_jsonEn ( '504', '' );
			}
			
			$cpObj = new CakeProController ();
			$proRes = $cpObj->getCakeProDetail ( $dataArray ['cpId'] );
			
			$dataArray ['cpName'] = $proRes ['title'];
			if (empty ( $dataArray ['cpId'] )) {
				$this->_jsonEn ( '504', '暂无该产品' );
			}
			$dataArray ['cpImg'] = $proRes ['listImgPath'];
			$dataArray ['sendType'] = Run::req ( 'cpid' );
			if (empty ( $dataArray ['sendType'] )) {
				$this->_jsonEn ( '504', '请选择配送方式' );
			}
			$dataArray ['oAddress'] = Run::req ( 'address' );
			if (empty ( $dataArray ['oAddress'] )) {
				$this->_jsonEn ( '504', '请输入配送地址' );
			}
			$dataArray ['oName'] = Run::req ( 'name' );
			if (empty ( $dataArray ['oName'] )) {
				$this->_jsonEn ( '504', '请输入收件人' );
			}
			$dataArray ['oTel'] = Run::req ( 'tel' );
			if (empty ( $dataArray ['oTel'] )) {
				$this->_jsonEn ( '504', '请输入联系电话' );
			}
			$dataArray ['petName'] = Run::req ( 'pname' );
			if (empty ( $dataArray ['petName'] )) {
				$this->_jsonEn ( '504', '请输入宠物名称' );
			}
			$dataArray ['petSex'] = Run::req ( 'psex' );
			if ($dataArray ['petSex']=='') {
				$this->_jsonEn ( '504', '请选择宠物性别' );
			}
			$dataArray ['petBirthday'] = Run::req ( 'pdate' );
			if (empty ( $dataArray ['petBirthday'] )) {
				$this->_jsonEn ( '504', '请选择宠物生日' );
			}
			$dataArray ['rTime'] = Run::req ( 'rTime' );
			if (empty ( $dataArray ['rTime'] )) {
				$this->_jsonEn ( '504', '请选择收货日期' );
			}
			$_n_date = date('Y-m-d',strtotime("+3 day"));
			if($dataArray['rTime']<$_n_date){
				$this->_jsonEn ( '504', '收货日期必须3天之后' );
			}
			
			$dataArray ['payMoney'] = $proRes ['nPrice'];
			$dataArray ['payCode'] = '';
			$dataArray ['payTime'] = '';
			$dataArray ['createTime'] = date ( 'Y-m-d H:i:s' );
			$dataArray ['oUser'] = '';
			$dataArray ['oMsg'] = '';
			$dataArray ['status'] = '1';
			
			$res = $obj->addCakeOrder ( $dataArray );
			if ($res) {
			
			} else {
				$this->_jsonEn ( '503', '支付失败' );
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
	
	/**
	 * 微信创建虚拟订单-返回sign标识，用于客户端支付
	 */
	public function pay($orderid) {
		$parObj = new ParamsController ();
		$openid = $parObj->getSessionParams ( 'openid' );
		
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$callBackUrl = APP_WEBSITE . 'c/CakeOrderPayCallback.php';
		$ip = $this->_getIp ();
		$rndStr = strtoupper ( $this->getRandomString ( 32, '3' ) );
		$payTitle = '宠业无忧在线支付蛋糕';
		
		$res = $this->getCakeOrderId ( $orderid );
		
		if (! $res) {
			return false;
		}
		
		$totalPrice = floatval ( $res ['payMoney'] ) * 100;
		
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
	
	/**
	 * 
	 * 支付成功回调
	 */
	public function payCallBack($params) {
		$res = json_decode ( json_encode ( simplexml_load_string ( $params, 'SimpleXMLElement', LIBXML_NOCDATA ) ), true );
		$saveRes = null;
		if ($res ['return_code'] == 'SUCCESS') {
			$obj = new CakeOrderModel ();
			$orderRes = $obj->getCakeOrder ( 'id="' . $res ['out_trade_no'] . '"', '', '', '1' );
			if (empty ( $orderRes )) {
			
			} else {
				$orderRes ['payTime'] = date ( 'Y-m-d H:i:s' );
				$orderRes ['payCode'] = $res ['transaction_id'];
				if ($orderRes ['status'] == '1') {
					$orderRes ['status'] = '2';
					//更新支付订单
					$saveRes = $obj->setCakeOrder ( $res ['out_trade_no'], $orderRes );
					
					echo '<xml>
						  <return_code><![CDATA[SUCCESS]]></return_code>
						  <return_msg><![CDATA[OK]]></return_msg>
						</xml>';
				}
			}
		} else {
		
		}
	}

}