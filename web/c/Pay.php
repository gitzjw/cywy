<?php
final class PayController extends Base {
	
	public function checkIdentity() {
		$_name = Run::req ( '_name' );
		$_idcard = Run::req ( '_idcard' );
		
		$mRes = $this->checkName ( $_idcard, $_name );
		$iRes = $this->checkInsRecord ( $mRes ['id'] );
		$_a = date ( 'm月d日', strtotime ( '+2 day', time () ) );
		if ($iRes ['iStatus'] == '0') {
			$_tmpStr = '该用户为首次投保，支付后，保单生效日期为' . $_a;
		} else if ($iRes ['iStatus'] == '1') {
			$_tmpStr = '该用户目前在保，结束日期为' . $iRes ['iEnd'];
		} else if ($iRes ['iStatus'] == '2') {
			$_tmpStr = '该用户投保已经过期，支付后，保单生效日期为' . $_a;
		}
		$this->_jsonEn ( '1', $_tmpStr . '@@@' . $iRes ['iStart'] . '@@@' . $iRes ['iEnd'] );
	}
	
	public function checkName($_idcard, $_name) {
		if (empty ( $_name )) {
			$this->_jsonEn ( '101', '请输入姓名' );
		}
		if (empty ( $_idcard )) {
			$this->_jsonEn ( '102', '请输入身份证' );
		}
		$isIdCard = $this->isIdCardNo ( $_idcard );
		if (! $isIdCard) {
			$this->_jsonEn ( '103', '身份证号错误' );
		}
		$cObj = new InsMemberController ();
		$mRes = $cObj->getInsMemberIdCard ( $_idcard );
		if (! $mRes) {
			//创建保单人
			$mRes = $this->createInsMember ();
		
		//$this->_jsonEn ( '104', '没有查询到相关人的信息' );
		}
		if ($mRes ['iName'] != $_name) {
			$this->_jsonEn ( '105', '姓名与身份证不符' );
		}
		return $mRes;
	}
	
	public function checkInsRecord($_insm_id) {
		$iObj = new InsController ();
		$iRes = $iObj->getInsInsuerId ( $_insm_id );
		if (! $iRes) {
			//创建投保记录
			$iRes = $this->createIns ( $_insm_id );
		
		//$this->_jsonEn ( '106', '没有查询到相关投保记录' );
		}
		return $iRes;
	}
	
	public function cOrder() {
		$_modNum = Run::req ( 'modNum' );
		$_np = Run::req ( '_np' );
		$_pay = intval ( $_modNum ) * floatval ( $_np );
		$_span = Run::req ( '_span' );
		$_oid = Run::req ( '_oid' );
		$_dataRes = array ();
		$_dataNewRes = array ();
		if (empty ( $_oid )) {
			for($i = 1; $i <= $_modNum; $i ++) {
				$_tmpD = 'd' . $i;
				$_dataRes [$_tmpD] = Run::req ( $_tmpD );
			}
			foreach ( $_dataRes as $v ) {
				$_vRes = explode ( '@@@', $v );
				$imRes = $this->checkName ( $_vRes ['1'], $_vRes ['0'] );
				$iRes = $this->checkInsRecord ( $imRes ['id'] );
				$_dataNewRes [] = array ('imRes' => $imRes, 'iRes' => $iRes );
			}
			$orderRes = $this->createInsPay ( $_pay, $_span );
			if (! $orderRes) {
				$this->_jsonEn ( '107', '创建支付订单失败' );
			}
			foreach ( $_dataNewRes as $v ) {
				$_tmpDataArr = array ('pId' => $orderRes ['id'], 'rPay' => $_np, 'iId' => $v ['iRes'] ['id'], 'rSpan' => $_span );
				$res = $this->createInsPayRecord ( $_tmpDataArr );
				if (! $res) {
					$this->_jsonEn ( '107', '创建支付订单详细订单记录失败，请重新发起' );
				}
			}
			$_oid = $orderRes ['id'];
		}
		
		$endRes = $this->pay ( $_oid );
		$endRes ['oid'] = $_oid;
		$this->_jsonEn ( '1', $endRes );
	}
	
	public function createInsPay($_pay, $_span) {
		$obj = new InsPayController ();
		$parObj = new ParamsController ();
		$user = $parObj->getSessionParams ( 'userDetail' );
		
		$_d ['rPay'] = $_pay;
		$_d ['rPayCode'] = '';
		$_d ['rPayTime'] = '';
		$_d ['rCreateTime'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['rSpan'] = $_span;
		$_d ['rStatus'] = '0';
		$_d ['uId'] = $user ['id'];
		
		$res = $obj->saveInsPay ( $_d );
		return $res;
	}
	
	public function createInsPayRecord($data) {
		$obj = new InsPayRecordModel ();
		$dataArray ['pId'] = $data ['pId'];
		$dataArray ['rCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$dataArray ['rPay'] = $data ['rPay'];
		$dataArray ['rStatus'] = '0';
		$dataArray ['iId'] = $data ['iId'];
		$dataArray ['rSpan'] = $data ['rSpan'];
		$res = $obj->addInsPayRecord ( $dataArray );
		return $res;
	}
	
	public function createInsMember() {
		$_id = Run::req ( 'id' );
		
		$_d ['iName'] = Run::req ( '_name' );
		$_d ['iIdCard'] = Run::req ( '_idcard' );
		
		$_year = date ( 'Y', time () );
		$_oYear = date ( 'Y', strtotime ( Run::getIdCardBirthday ( $_d ['iIdCard'] ) ) );
		
		$_d ['iSex'] = Run::getIdCardSex ( $_d ['iIdCard'] );
		$_d ['iAge'] = $_year - $_oYear;
		$_d ['iTelNumber'] = '';
		$_d ['iAddress'] = '';
		$_d ['iUserId'] = '';
		$_d ['iCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['iuStatus'] = '1';
		
		$sObj = D ( 'InsMember' );
		$_d ['id'] = $this->Sysid ();
		$res = $sObj->addInsMember ( $_d );
		
		if ($res) {
			return $_d;
		} else {
			return false;
		}
	}
	
	public function createIns($insmid) {
		
		$_d ['iSpan'] = '0';
		$_d ['iInsId'] = '000006252992088';
		$_d ['wType'] = '5';
		$_d ['smIdOne'] = '1';
		$_d ['smIdTwo'] = '1';
		$_d ['iStart'] = '';
		$_d ['iEnd'] = '';
		$_d ['iStatus'] = '0';
		$_d ['iUserId'] = '';
		$_d ['iInsuerId'] = $insmid;
		
		$sObj = D ( 'Ins' );
		$_d ['id'] = $this->Sysid ();
		$_d ['iCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['iUpdateDate'] = '';
		$res = $sObj->addIns ( $_d );
		
		if ($res) {
			return $_d;
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
		$callBackUrl = APP_WEBSITE . 'c/PayCallback.php';
		$ip = $this->_getIp ();
		$rndStr = strtoupper ( $this->getRandomString ( 32, '3' ) );
		$openid = $user ['openId'];
		$payTitle = '宠业无忧在线支付';
		
		$insObj = new InsPayController ();
		$res = $insObj->getInsPayId ( $orderid );
		if (! $res) {
			return false;
		} else if ($res ['uId'] != $user ['id']) {
			return false;
		}
		$totalPrice = floatval ( $res ['rPay'] ) * 100;
		
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
			$obj = new InsPayController ();
			$orderRes = $obj->getInsPayId ( $res ['out_trade_no'] );
			if (empty ( $orderRes )) {
			
			} else {
				$orderRes ['rPayTime'] = date ( 'Y-m-d H:i:s', time () );
				$orderRes ['rPayCode'] = $res ['transaction_id'];
				if ($orderRes ['rStatus'] == '0') {
					$orderRes ['rStatus'] = '1';
					//更新支付订单
					$saveRes = $obj->saveInsPay ( $orderRes );
					//更新订单详细记录
					$irObj = new InsPayRecordController ();
					$saveResO = $irObj->updateInsPayRecordPid ( $res ['out_trade_no'], '1' );
					//更新保单时间 状态 开始 结束日期
					$findRes = $irObj->getInsPayRecordPid ( $res ['out_trade_no'] );
					$this->_updateInsStatus ( $findRes );
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
	
	private function _updateInsStatus($_data) {
		$obj = new InsController ();
		$_span = $_data ['0'] ['rSpan'];
		foreach ( $_data as $k => $v ) {
			$_tmpRes = $obj->getInsId ( $v ['iId'] );
			if ($_tmpRes ['iStatus'] == '0') {
				$_tmpRes ['iStart'] = date ( 'Y-m-d H:i:s', strtotime ( "+2 day", time () ) );
				$_dateEnd = date ( "Y-m-d H:i:s", strtotime ( "-1 day", strtotime ( "+{$_span} months", strtotime ( $_tmpRes ['iStart'] ) ) ) );
				$_tmpRes ['iEnd'] = $_dateEnd;
				$_tmpRes ['iSpan'] = $_span;
			} elseif ($_tmpRes ['iStatus'] == '2') {
				$_tmpRes ['iStart'] = date ( 'Y-m-d H:i:s', strtotime ( "+2 day", time () ) );
				$_dateEnd = date ( "Y-m-d H:i:s", strtotime ( "-1 day", strtotime ( "+{$_span} months", strtotime ( $_tmpRes ['iStart'] ) ) ) );
				$_tmpRes ['iEnd'] = $_dateEnd;
				$_tmpRes ['iSpan'] = $_span;
			} else {
				$_dateEnd = date ( "Y-m-d H:i:s", strtotime ( "-1 day", strtotime ( "+{$_span} months", strtotime ( $_tmpRes ['iEnd'] ) ) ) );
				$_tmpRes ['iEnd'] = $_dateEnd;
				$_tmpRes ['iSpan'] = intval ( $_span ) + intval ( $_tmpRes ['iSpan'] );
			}
			
			$_tmpRes ['iStatus'] = '1';
			$res = $obj->updateIns ( $_tmpRes ['id'], $_tmpRes );
		}
	}

}