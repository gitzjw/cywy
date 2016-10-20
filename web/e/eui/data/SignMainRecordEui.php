<?php
final class SignMainRecordEuiController extends Base {
	
	public function getSignMainRecordList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new SignMainRecordModel ();
		$w = $this->getWhere ();
		$ueObj->setField ( '*' );
		$res = $ueObj->getSignMainRecord ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getSignMainRecord ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_uid = Run::req ( '_uid' );
		$_month = Run::req ( '_month' );
		$_day = Run::req ( '_day' );
		if (! $_uid && ! $_month && ! $_day) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_uid) {
			$w .= ' and uId="' . $_uid . '" ';
		}
		if ($_month) {
			$w .= ' and sMonth="' . $_month . '" ';
		}
		if ($_day) {
			$_date = date ( 'Y-m-d', strtotime ( $_day ) );
			$w .= ' and sDate="' . $_date . '" ';
		}
		return $w;
	}
	public function getSignMainRecordUserAllCount() {
		$_uId = Run::req ( 'uId' );
		$_date = Run::req ( 'month' );
		if ($_date == '') {
			$_date = date ( 'Y-m' );
		}
		$obj = D ( 'SignMainRecord' );
		$obj->setField ( ' count(id) as total ' );
		$w = " sMonth='{$_date}' and uId='{$_uId}' ";
		$res = $obj->getSignMainRecord ( $w, '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getSignMainRecordAllCount() {
		$obj = D ( 'SignMainRecord' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignMainRecord ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	//签到
	public function sign() {
		$uD = $this->getUserDetail ();
		if (! $uD) {
			$this->_jsonEn ( '201', '参加签到活动，需要登录' );
		}
		$iObj = new InsController ();
		$iRes = $iObj->getInsUsersId ( $uD ['id'] );
		if (! $iRes) {
			$this->_jsonEn ( '205', '参与签到活动，需要您是宠业无忧的投保用户，未投保用户不能参与。' );
		} else {
			if ($iRes ['iStatus'] != '1') {
				$this->_jsonEn ( '205', '参与签到活动，需要您是宠业无忧的投保用户，未投保用户不能参与。' );
			}
		}
		$todaySign = $this->checkUserSignSingle ( $uD ['id'] );
		if ($todaySign) {
			$this->_jsonEn ( '202', '您今天已经签到' );
		}
		//查询签到用户详细
		$sObj = new SignMainController ();
		$sRes = $sObj->findSignMainUid ( $uD ['id'] );
		if (empty ( $sRes )) {
			$this->_jsonEn ( '203', '未查询到签到用户' );
		}
		
		//查询昨天签到记录
		$oldDaySign = $this->checkUserSignSingle ( $uD ['id'], date ( 'Y-m-d', strtotime ( "-1 day", time () ) ) );
		if ($oldDaySign) {
			$sRes ['mContNum'] = intval ( $sRes ['mContNum'] ) + 1;
			$sRes ['sContNum'] = intval ( $sRes ['sContNum'] ) + 1;
		} else {
			$sRes ['mContNum'] = '1';
			$sRes ['sContNum'] = '1';
		}
		
		$sRes ['mTotalNum'] = intval ( $sRes ['mTotalNum'] ) + 1;
		$sRes ['sTotalNum'] = intval ( $sRes ['sTotalNum'] ) + 1;
		
		//是否为一个月的第一天
		$_date_one = date ( 'd' );
		if ($_date_one == '1') {
			$sRes ['mContNum'] = 1;
			$sRes ['mTotalNum'] = 1;
		}
		//签到
		$smrRes = $this->addSignMainRecord ();
		if ($smrRes) {
			//更新用户签到资料
			$updSignUser = $sObj->updateSignMain ( $sRes );
			
			//发放奖品操作 备用 
			$swrObj = new SignWinRecordController ();
			$swrObj->sendWinPro ();
			
			//推送用户新闻
			$snObj = new SignNewsController ();
			$snObj->sendSignNews ();
			
			$this->_jsonEn ( '1', '签到成功' );
		} else {
			$this->_jsonEn ( '204', '签到失败' );
		}
	}
	
	//验证用户签到
	public function checkUserSignSingle($uid = '', $date = '') {
		if (empty ( $uid )) {
			return false;
		}
		if ($date == '') {
			$date = date ( 'Y-m-d' );
		}
		$obj = D ( 'SignMainRecord' );
		$w = " uId='{$uid}' and sDate='{$date}' ";
		$res = $obj->getSignMainRecord ( $w, '', '1', '1' );
		if ($res) {
			return $res;
		} else {
			return false;
		}
	}
	
	//查询用户某月签到记录 $date 2015-01
	public function findUserMonthRecord($date = '') {
		if ($date == '') {
			$date = date ( 'Y-m' );
		}
		$uD = $this->getUserDetail ();
		$obj = D ( 'SignMainRecord' );
		$w = " sMonth='{$date}' and  uId='{$uD['id']}'";
		$res = $obj->getSignMainRecord ( $w );
		if ($res) {
			return $res;
		} else {
			return array ();
		}
	}
	
	//添加用户签到记录
	public function addSignMainRecord() {
		$uD = $this->getUserDetail ();
		if (! $uD) {
			return false;
		}
		$_date_m = date ( 'Y-m' );
		$_date_d = date ( 'Y-m-d' );
		$_date_h = date ( 'H:i:s' );
		
		$data ['uId'] = $uD ['id'];
		$data ['sMonth'] = $_date_m;
		$data ['sDate'] = $_date_d;
		$data ['sTime'] = $_date_h;
		$obj = D ( 'SignMainRecord' );
		$res = $obj->addSignMainRecord ( $data );
		return $res;
	}
}