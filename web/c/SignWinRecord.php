<?php
final class SignWinRecordController extends Base {
	
	public function getSignWinRecordUserList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		
		$_uId = Run::req ( 'uId' );
		$_date = Run::req ( 'month' );
		if ($_date == '') {
			$_date = date ( 'Y-m' );
		}
		$w = " cMonth='{$_date}' and uId='{$_uId}' ";
		
		$obj = D ( 'SignWinRecord' );
		$obj->setField ( ' *,(select title from sign_day_config sdc where sign_win_record.scId=sdc.id) as scName ,
			(SELECT title FROM sign_win_pro swp WHERE sign_win_record.spId=swp.id) AS spName  ' );
		$res = $obj->getSignWinRecord ( $w, '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getSignWinRecordUserAllCount() {
		$_uId = Run::req ( 'uId' );
		$_date = Run::req ( 'month' );
		if ($_date == '') {
			$_date = date ( 'Y-m' );
		}
		$w = " cMonth='{$_date}' and uId='{$_uId}' ";
		
		$obj = D ( 'SignWinRecord' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignWinRecord ( $w, '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getSignWinRecordList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'SignWinRecord' );
		$obj->setField ( ' *,(select title from sign_day_config sdc where sign_win_record.scId=sdc.id) as scName ,
			(SELECT title FROM sign_win_pro swp WHERE sign_win_record.spId=swp.id) AS spName  ' );
		$res = $obj->getSignWinRecord ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getSignWinRecordAllCount() {
		$obj = D ( 'SignWinRecord' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignWinRecord ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	//发放奖励
	public function sendWinPro() {
		//查询接收奖励的用户
		$smObj = new SignMainController ();
		$smRes = $smObj->findSignMainUid ();
		
		$_strRes = $this->checkWinSDC ( $smRes );
		
		$this->checkIsWin ( $_strRes );
	}
	
	//推送消息
	public function sendWinMsg($msg = '') {
		$uD = $this->getUserDetail ();
		$str = '{
				    "touser":"' . $uD ['openId'] . '",
				    "msgtype":"text",
				    "text":
				    {
				         "content":"' . $msg . '"
				    }
				}';
		$res = WechatToken::_sendWechatCustom ( $str );
	}
	
	//检验是否已经获得过奖励 同时发放奖励
	public function checkIsWin($_strRes) {
		$uD = $this->getUserDetail ();
		$_tmpRes = explode ( ',', $_strRes );
		array_pop ( $_tmpRes );
		$swpObj = new SignWinProController ();
		foreach ( $_tmpRes as $v ) {
			$_tmpPro = $swpObj->getSignWinProScidCdate ( $v );
			$this->findWinRecordUserProTime ( $uD ['id'], $v, $_tmpPro ['id'], $_tmpPro ['winMsg'] );
		}
	}
	
	//查询用户、分类、奖品、时间记录
	public function findWinRecordUserProTime($uid, $scid, $spid, $msg, $date = '') {
		if ($date == '') {
			$date = date ( 'Y-m' );
		}
		$swrObj = D ( 'SignWinRecord' );
		$w = " uId='{$uid}' and scId='{$scid}' and spId='{$spid}' and cMonth='{$date}' ";
		$_tmpRes = $swrObj->getSignWinRecord ( $w );
		//如果没有记录，则发送奖励
		if (! $_tmpRes) {
			$_d ['uId'] = $uid;
			$_d ['scId'] = $scid;
			$_d ['spId'] = $spid;
			$_d ['date'] = $date;
			$res = $this->saveSignWinRecord ( $_d );
			//发送奖励推送
			$this->sendWinMsg ( $msg );
		}
	}
	
	//检验属于那一类奖励
	public function checkWinSDC($smRes) {
		$sdcObj = new SignDayConfigController ();
		$sdcRes = $sdcObj->getSignDayConfigDate ();
		$_str = '';
		//22 连续 23 总计 24 特殊
		foreach ( $sdcRes as $k => $v ) {
			if ($v ['wType'] == '11') {
				$_day = $v ['cDayNum'];
				if ($_day == $smRes ['mContNum']) {
					$_str .= $v ['id'] . ',';
				}
			}
			if ($v ['wType'] == '12') {
				$_day = $v ['cDayNum'];
				if ($_day == $smRes ['mTotalNum']) {
					$_str .= $v ['id'] . ',';
				}
			}
			if ($v ['wType'] == '13') {
				$_day = $v ['cSpeDate'];
				$_date = date ( 'Y-m-d' );
				if ($_day == $_date) {
					$_str .= $v ['id'] . ',';
				}
			}
		}
		return $_str;
	}
	
	//添加奖励记录
	public function saveSignWinRecord($_d) {
		$swrObj = D ( 'SignWinRecord' );
		
		$data ['uId'] = $_d ['uId'];
		$data ['scId'] = $_d ['scId'];
		$data ['createDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$data ['status'] = '1';
		$data ['spId'] = $_d ['spId'];
		$data ['cMonth'] = $_d ['date'];
		$data ['oUser'] = '';
		$data ['oImg'] = '';
		
		$res = $swrObj->addSignWinRecord ( $data );
		return $res;
	}
	//id查询奖励
	public function getSignWinRecordId($id = '') {
		$obj = D ( 'SignWinRecord' );
		$obj->setField ( ' *,(select title from sign_day_config sdc where sign_win_record.scId=sdc.id) as scName ,
			(SELECT title FROM sign_win_pro swp WHERE sign_win_record.spId=swp.id) AS spName  ' );
		$res = $obj->getSignWinRecord ( "id='{$id}'", '', '1', '1' );
		return $res;
	}
	
	//更新奖励记录
	public function updateSignWinRecord() {
		$_id = Run::req ( 'id' );
		$swrObj = D ( 'SignWinRecord' );
		$fRes = $this->getSignWinRecordId ( $_id );
		if (empty ( $fRes )) {
			Run::show_msg ( '更新失败，没有该记录' );
		}
		unset ( $fRes ['scName'] );
		unset ( $fRes ['spName'] );
		$fRes ['oUser'] = Run::req ( 'oUser' );
		$imgPath = $this->uploadImg ( $_FILES ['upload'] );
		if ($imgPath) {
			$fRes ['oImg'] = $imgPath;
		} else {
			$fRes ['oImg'] = Run::req ( 'oImg' );
		}
		$res = $swrObj->setSignWinRecord ( $_id, $fRes );
		if ($res) {
			Run::show_msg ( '更新成功' );
		} else {
			Run::show_msg ( '更新失败' );
		}
	}

}