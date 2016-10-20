<?php
final class RepairPayController extends Base {
	
	public function cOrder() {
		$modNum = Run::req ( 'modNum' );
		$modVal = Run::req ( 'modVal' );
		$nTotal = Run::req ( 'nTotal' );
		$total = Run::req ( 'total' );
		
		$parObj = new ParamsController ();
		
		$_paySign = Run::req ( 'repairPaySign' );
		
		$_fwfs = $parObj->getSessionParams ( 'mjdFwfsId' );
		
		if ($modVal < 5) {
			$this->_jsonEn ( '110', '至少需要5把，才能下单' );
		}
		
		if (! $_fwfs) {
			$this->_jsonEn ( '108', '请选择服务方式' );
		}
		
		if ($nTotal == '0') {
			$this->_jsonEn ( '109', '您目前所在的城市不支持该服务' );
		}
		
		$_oid = Run::req ( '_oid' );
		
		if (empty ( $_oid )) {
			//创建订单
			$orderRes = $this->createRepairOrder ( $nTotal );
			
			if (! $orderRes) {
				$this->_jsonEn ( '107', '创建支付订单失败' );
			}
			
			if ($_paySign == 'mjd') {
				//磨剪刀详情
				for($i = 1; $i <= $modNum; $i ++) {
					$_a = explode ( '@@', Run::req ( 'data' . $i ) );
					if ($_a [1] > 0) {
						$this->createRepairOrderDetail ( $orderRes, $_a [0], $_a [1], $_a [4] );
					}
				}
			}
			
			//订单记录
			$this->createRepairOrderHistory ( $orderRes, '1' );
			
			$_oid = $orderRes ['id'];
		}
		
		$endRes = $this->pay ( $_oid );
		$endRes ['oid'] = $_oid;
		$this->_jsonEn ( '1', $endRes );
	}
	
	public function createRepairOrder($ntotal) {
		$obj = new RepairOrderModel ();
		$parObj = new ParamsController ();
		$user = $parObj->getSessionParams ( 'userDetail' );
		
		$dataArray ['id'] = $this->SysOrderId ();
		$dataArray ['uId'] = $user ['id'];
		$dataArray ['wType'] = $parObj->getSessionParams ( 'mjdFwfsId' );
		$dataArray ['roCity'] = $parObj->getSessionParams ( 'mjdCityId' );
		$dataArray ['mAddress'] = $parObj->getSessionParams ( 'madsVal' );
		$dataArray ['bAddress'] = $parObj->getSessionParams ( 'badsVal' );
		$dataArray ['cAddress'] = $parObj->getSessionParams ( 'cadsVal' );
		$dataArray ['roPrice'] = $ntotal;
		$dataArray ['roStatus'] = '1';
		$dataArray ['roExpNum'] = '';
		$dataArray ['roExpContent'] = '';
		$dataArray ['roCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$dataArray ['roPayDate'] = '';
		$dataArray ['roPayCode'] = '';
		$dataArray ['roMark'] = '';
		
		$res = $obj->addRepairOrder ( $dataArray );
		return $dataArray;
	}
	
	public function createRepairOrderDetail($oData, $wType, $num, $price) {
		$obj = new RepairOrderDetailModel ();
		
		$dataArray ['oId'] = $oData ['id'];
		$dataArray ['uId'] = $oData ['uId'];
		$dataArray ['wType'] = $wType;
		$dataArray ['odNum'] = $num;
		$dataArray ['odPrice'] = $price;
		$dataArray ['odStatus'] = '1';
		$dataArray ['odExpNum'] = '';
		$dataArray ['odExpContent'] = '';
		
		$res = $obj->addRepairOrderDetail ( $dataArray );
		return $res;
	}
	
	public function createRepairOrderHistory($oData, $_s = '1') {
		$roObj = new RepairOrderController ();
		$obj = new RepairOrderHistoryModel ();
		
		$dataArray ['uId'] = $oData ['uId'];
		$dataArray ['oId'] = $oData ['id'];
		$dataArray ['createTime'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$dataArray ['ohStatus'] = $_s;
		$dataArray ['ohText'] = $roObj->getOrderStatus ( $_s );
		
		$res = $obj->addRepairOrderHistory ( $dataArray );
		
		if ($res) {
			return $res;
		} else {
			return false;
		}
	}
	
	/**
	 * 微信创建虚拟订单-返回sign标识，用于客户端支付
	 */
	public function pay($orderid) {
		$parObj = new ParamsController ();
		$user = $parObj->getSessionParams ( 'userDetail' );
		
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$callBackUrl = APP_WEBSITE . 'c/RepairPayCallback.php';
		$ip = $this->_getIp ();
		$rndStr = strtoupper ( $this->getRandomString ( 32, '3' ) );
		$openid = $user ['openId'];
		$payTitle = '宠业无忧在线支付';
		
		$insObj = new RepairOrderController ();
		$res = $insObj->getRepairOrderId ( $orderid );
		if (! $res) {
			return false;
		} else if ($res ['uId'] != $user ['id']) {
			return false;
		}
		$totalPrice = floatval ( $res ['roPrice'] ) * 100;
		
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
			$obj = new RepairOrderController ();
			$orderRes = $obj->getRepairOrderId ( $res ['out_trade_no'] );
			if (empty ( $orderRes )) {
			
			} else {
				$orderRes ['roPayDate'] = date ( 'Y-m-d H:i:s', time () );
				$orderRes ['roPayCode'] = $res ['transaction_id'];
				if ($orderRes ['roStatus'] <= '1') {
					$orderRes ['roStatus'] = '2';
					//更新支付订单
					$saveRes = $obj->setRepairOrder ( $orderRes );
					
					//更新订单详细记录
					$irObj = new RepairOrderDetailController ();
					$saveResO = $irObj->updateRepairOrderDetailStatus ( $res ['out_trade_no'], '2' );
					
					//添加订单操作记录					
					$this->createRepairOrderHistory ( $orderRes, '2' );
					echo '<xml>
						  <return_code><![CDATA[SUCCESS]]></return_code>
						  <return_msg><![CDATA[OK]]></return_msg>
						</xml>';
				
		//支付成功发送用户推送
				//$this->_sendWechatUserMessage ( $res ['out_trade_no'], $orderRes );
				

				//向用户发送推送
				//$this->_sendWechatUserDetailMessage ( $res ['out_trade_no'], $orderRes );
				

				}
			}
		} else {
		
		}
	}

}