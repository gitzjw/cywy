<?php
final class ActivityController extends Base {
	
	public function getActivityList($_t = '') {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'Activity' );
		$obj->setTable ( $_t );
		$res = $obj->getActivity ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getActivityAllCount($_t = '') {
		$obj = D ( 'Activity' );
		$obj->setTable ( $_t );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getActivity ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function checkTel($tel, $_t = '') {
		$obj = D ( 'Activity' );
		$obj->setTable ( $_t );
		$w = ' tel="' . $tel . '" and `status`="2" ';
		$res = $obj->getActivity ( $w, '', '', '1' );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}

	public function saveActivityTmpLS() {
		$_id = Run::req ( 'id' );
		$_t = Run::req ( '_t' );
		$_d ['city'] = Run::req ( 'city' );
		if (! $_d ['city']) {
			$this->_jsonEn ( '402', '没有城市' );
		}
		$_d ['xm'] = Run::req ( 'xm' );
		if (! $_d ['xm']) {
			$this->_jsonEn ( '402', '请输入姓名' );
		}
		$_d ['tel'] = Run::req ( 'tel' );
		if (! $_d ['tel'] || strlen ( $_d ['tel'] ) != '11') {
			$this->_jsonEn ( '402', '请检查联系电话' );
		}
		$_d ['shop'] = Run::req ( 'shop' );
		if (! $_d ['shop']) {
			$this->_jsonEn ( '402', '请输入店名' );
		}
		$_d ['shopI'] = Run::req ( 'shopI' );
		if (! $_d ['shopI']) {
			$this->_jsonEn ( '402', '请输入店内人数' );
		}
		$_d ['ads'] = Run::req ( 'ads' );
		if (! $_d ['ads']) {
			$this->_jsonEn ( '402', '请输入地址' );
		}
		$_d ['ks'] = Run::req ( 'ks' );
		if (! $_d ['ks']) {
			$this->_jsonEn ( '402', '请输入代金券编码开始' );
		}
		if (strlen ( $_d ['ks'] ) != 8) {
			$this->_jsonEn ( '402', '请输入8位正确代金券编码' );
		}
		$_d ['js'] = Run::req ( 'js' );
		if (! $_d ['js']) {
			$this->_jsonEn ( '402', '请输入代金券编码结束' );
		}
		if (strlen ( $_d ['js'] ) != 8) {
			$this->_jsonEn ( '402', '请输入8位正确代金券编码' );
		}
		$_d ['cdate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['status'] = '2';
		
		$_tmpRes = $this->checkTel ( $_d ['tel'], $_t );
		if (! empty ( $_tmpRes )) {
			$this->_jsonEn ( '402', '该号码主人已经填写资料' );
		}
		
		$sObj = D ( 'Activity' );
		$sObj->setTable ( $_t );
		if ($_id) {
			$res = $sObj->setActivity ( $_id, $_d );
		} else {
			$res = $sObj->addActivity ( $_d );
		}
		
		if ($res) {
			$this->_jsonEn ( '1', '登记成功' );
		}
	}
	
	public function saveActivityTmpOne() {
		$_id = Run::req ( 'id' );
		$_t = Run::req ( '_t' );
		$_d ['xl'] = Run::req ( 'xl' );
		if (! $_d ['xl']) {
			$this->_jsonEn ( '402', '请选择线路' );
		}
		$_d ['xm'] = Run::req ( 'xm' );
		if (! $_d ['xm']) {
			$this->_jsonEn ( '402', '请输入姓名' );
		}
		$_d ['tel'] = Run::req ( 'tel' );
		if (! $_d ['tel'] || strlen ( $_d ['tel'] ) != '11') {
			$this->_jsonEn ( '402', '请输入本人正确的联系电话' );
		}
		$_d ['shop'] = Run::req ( 'shop' );
		if (! $_d ['shop']) {
			$this->_jsonEn ( '402', '请输入店名' );
		}
		$_d ['idcard'] = Run::req ( 'idcard' );
		$_isIdCard = $this->isIdCardNo ( $_d ['idcard'] );
		if (! $_isIdCard) {
			$this->_jsonEn ( '402', '请输入正确的身份证' );
		}
		$_d ['mark'] = Run::req ( 'mark' );
		$_d ['cdate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['status'] = '2';
		
		$_tmpRes = $this->checkTel ( $_d ['tel'], $_t );
		if (! empty ( $_tmpRes )) {
			$this->_jsonEn ( '402', '您已提交过抢座信息，无需重复提交，客户会与您联系！' );
		}
		
		$sObj = D ( 'Activity' );
		$sObj->setTable ( $_t );
		if ($_id) {
			$res = $sObj->setActivity ( $_id, $_d );
		} else {
			$res = $sObj->addActivity ( $_d );
		}
		
		if ($res) {
			$this->_jsonEn ( '1', '抢座申请已提交，客服稍后会与您联系确认！' );
		}
	}
	
	public function saveActivityTmp() {
		$_id = Run::req ( 'id' );
		$_t = Run::req ( '_t' );
		$_d ['city'] = Run::req ( 'city' );
		if (! $_d ['city']) {
			Run::show_msg ( '没有城市' );
		}
		$_d ['xm'] = Run::req ( 'xm' );
		if (! $_d ['xm']) {
			Run::show_msg ( '请输入姓名' );
		}
		$_d ['tel'] = Run::req ( 'tel' );
		if (! $_d ['tel'] || strlen ( $_d ['tel'] ) != '11') {
			Run::show_msg ( '请检查联系电话' );
		}
		$_d ['shop'] = Run::req ( 'shop' );
		if (! $_d ['shop']) {
			Run::show_msg ( '请输入店名' );
		}
		$_d ['xb'] = Run::req ( 'xb' );
		if (! $_d ['xb']) {
			Run::show_msg ( '请输入性别' );
		}
		$_d ['exp'] = Run::req ( 'exp' );
		if (! $_d ['exp']) {
			Run::show_msg ( '请输入工作年限' );
		}
		$_d ['lv'] = Run::req ( 'lv' );
		if (! $_d ['lv']) {
			Run::show_msg ( '请选择等级' );
		}
		$_d ['zk'] = Run::req ( 'zk' );
		if (! $_d ['zk']) {
			Run::show_msg ( '请选择目前状况' );
		}
		$_d ['money'] = Run::req ( 'money' );
		if (! $_d ['money']) {
			Run::show_msg ( '请输入期望薪资' );
		}
		$_d ['zx'] = Run::req ( 'zx' );
		if (! $_d ['zx']) {
			Run::show_msg ( '请输入擅长造型' );
		}
		$_d ['mmmr'] = Run::req ( 'mmmr' );
		if (! $_d ['mmmr']) {
			Run::show_msg ( '请选择猫咪美容' );
		}
		$_d ['iszs'] = Run::req ( 'iszs' );
		if (! $_d ['iszs']) {
			Run::show_msg ( '请选择是否住宿' );
		}
		$_d ['remark'] = Run::req ( 'remark' );
		if (! $_d ['remark']) {
			//Run::show_msg('请选择等级' );
		}
		
		$_d ['cdate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['status'] = '2';
		
		$_tmpRes = $this->checkTel ( $_d ['tel'], $_t );
		if (! empty ( $_tmpRes )) {
			Run::show_msg ( '该号码主人已经填写资料' );
		}
		
		$sObj = D ( 'Activity' );
		$sObj->setTable ( $_t );
		if ($_id) {
			$res = $sObj->setActivity ( $_id, $_d );
		} else {
			$res = $sObj->addActivity ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '您的应聘信息已经收到，店主收到信息后会与您取得联系，请耐心等待！','1','/s/20160405/' );
		}
	}
	
	public function saveActivity() {
		$_id = Run::req ( 'id' );
		$_t = Run::req ( '_t' );
		$totalRes = $this->checkCount ();
		if ($totalRes ['total'] >= 10) {
			$this->_jsonEn ( '409', '本次活动报名人数已满，请关注下期活动！' );
		}
		$_d ['xm'] = Run::req ( 'xm' );
		if (! $_d ['xm']) {
			$this->_jsonEn ( '402', '请输入姓名' );
		}
		$_d ['tel'] = Run::req ( 'tel' );
		if (! $_d ['tel'] || strlen ( $_d ['tel'] ) != '11') {
			$this->_jsonEn ( '402', '请检查联系电话' );
		}
		$_d ['shop'] = Run::req ( 'shop' );
		if (! $_d ['shop']) {
			$this->_jsonEn ( '402', '请输入店名' );
		}
		$_d ['exp'] = Run::req ( 'exp' );
		if (! $_d ['exp']) {
			$this->_jsonEn ( '402', '请输入从业年限' );
		}
		$_d ['pz'] = Run::req ( 'pz' );
		if (! $_d ['pz']) {
			$this->_jsonEn ( '402', '请输入狗狗品种' );
		}
		$_d ['content'] = Run::req ( 'content' );
		if (! $_d ['content']) {
			$this->_jsonEn ( '402', '请填写想学习的内容' );
		}
		$_d ['lv'] = Run::req ( 'lv' );
		if (! $_d ['lv']) {
			$this->_jsonEn ( '402', '请选择等级' );
		}
		$_d ['area'] = Run::req ( 'area' );
		if (! $_d ['area']) {
			$this->_jsonEn ( '402', '请输入地区' );
		}
		$_d ['cdate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['status'] = '2';
		
		$_tmpRes = $this->checkTel ( $_d ['tel'], $_t );
		if (! empty ( $_tmpRes )) {
			$this->_jsonEn ( '402', '该号码主人已经报名，请勿重复报名' );
		}
		$_oid = $this->SysOrderId ();
		$_d ['id'] = $_oid;
		$_d ['paycode'] = '';
		$_d ['paytime'] = '';
		$_d ['paymoney'] = '0.00';
		$sObj = D ( 'Activity' );
		$sObj->setTable ( $_t );
		if ($_id) {
			$res = $sObj->setActivity ( $_id, $_d );
		} else {
			$res = $sObj->addActivity ( $_d );
		}
		
		if ($res) {
			$this->_jsonEn ( '1', '报名申请成功，小萌同学审核后会与您取得联系。' );
		}
	}
	
	public function checkCount() {
		$_t = Run::req ( '_t' );
		$_area = Run::req ( 'area' );
		$obj = new ActivityModel ();
		$obj->setTable ( $_t );
		$w = ' `status`="2" ';
		if (! empty ( $_area )) {
			$w .= ' and `area`="' . $_area . '" ';
		}
		$obj->setField ( 'count(id) as total' );
		$res = $obj->getActivity ( $w, '', '', '1' );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function saveActivityPay() {
		$totalRes = $this->checkCount ();
		$_d ['area'] = Run::req ( 'area' );
		
		/*
		if($_d ['area']=='北京'){
			if($totalRes['total']>=5){
				$this->_jsonEn('409','本次活动报名人数已满，请关注下期活动！');
			}
		}
		else{
			if($totalRes['total']>=15){
				$this->_jsonEn('409','本次活动报名人数已满，请关注下期活动！');
			}
		}
		*/
		
		$_oid = Run::req ( '_oid' );
		if (! $_oid) {
			$_t = Run::req ( '_t' );
			$_d ['xm'] = Run::req ( 'xm' );
			if (! $_d ['xm']) {
				$this->_jsonEn ( '402', '请输入姓名' );
			}
			$_d ['tel'] = Run::req ( 'tel' );
			if (! $_d ['tel'] || strlen ( $_d ['tel'] ) != '11') {
				$this->_jsonEn ( '402', '请检查联系电话' );
			}
			$_d ['shop'] = Run::req ( 'shop' );
			if (! $_d ['shop']) {
				$this->_jsonEn ( '402', '请输入店名' );
			}
			$_d ['exp'] = Run::req ( 'exp' );
			if (! $_d ['exp']) {
				$this->_jsonEn ( '402', '请输入从业年限' );
			}
			$_d ['pz'] = Run::req ( 'pz' );
			if (! $_d ['pz']) {
				$this->_jsonEn ( '402', '请输入狗狗品种' );
			}
			$_d ['content'] = Run::req ( 'content' );
			if (! $_d ['content']) {
				$this->_jsonEn ( '402', '请填写想学习的内容' );
			}
			$_d ['lv'] = Run::req ( 'lv' );
			if (! $_d ['lv']) {
				$this->_jsonEn ( '402', '请选择等级' );
			}
			$_d ['area'] = Run::req ( 'area' );
			if (! $_d ['area']) {
				$this->_jsonEn ( '402', '请输入地区' );
			}
			$_d ['cdate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
			
			$_tmpRes = $this->checkTel ( $_d ['tel'], $_t );
			if (! empty ( $_tmpRes )) {
				$this->_jsonEn ( '402', '该号码主人已经报名，请勿重复报名' );
			}
			$_oid = $this->SysOrderId ();
			$_d ['id'] = $_oid;
			$_d ['paycode'] = '';
			$_d ['paytime'] = '';
			$_d ['paymoney'] = '50.00';
			$sObj = D ( 'Activity' );
			$sObj->setTable ( $_t );
			$res = $sObj->addActivity ( $_d );
		}
		
		$endRes = $this->pay ( $_oid );
		$endRes ['oid'] = $_oid;
		$this->_jsonEn ( '1', $endRes );
	}
	
	/**
	 * 微信创建虚拟订单-返回sign标识，用于客户端支付
	 */
	public function pay($orderid) {
		$parObj = new ParamsController ();
		$openid = $parObj->getSessionParams ( 'openid' );
		
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$callBackUrl = APP_WEBSITE . 'c/ActivityPayCallback.php';
		$ip = $this->_getIp ();
		$rndStr = strtoupper ( $this->getRandomString ( 32, '3' ) );
		$payTitle = '宠业无忧在线支付活动';
		
		$totalPrice = 50.00 * 100;
		//$totalPrice = 0.01 * 100;
		

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
	public function payCallBack($params, $_t = '') {
		$res = json_decode ( json_encode ( simplexml_load_string ( $params, 'SimpleXMLElement', LIBXML_NOCDATA ) ), true );
		$saveRes = null;
		if ($res ['return_code'] == 'SUCCESS') {
			$obj = new ActivityModel ();
			$obj->setTable ( $_t );
			$orderRes = $obj->getActivity ( 'id="' . $res ['out_trade_no'] . '"', '', '', '1' );
			if (empty ( $orderRes )) {
			
			} else {
				$orderRes ['paytime'] = date ( 'Y-m-d H:i:s' );
				$orderRes ['paycode'] = $res ['transaction_id'];
				if ($orderRes ['status'] == '1') {
					$orderRes ['status'] = '2';
					//更新支付订单
					$saveRes = $obj->setActivity ( $res ['out_trade_no'], $orderRes );
					
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