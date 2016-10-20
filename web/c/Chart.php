<?php
final class ChartController extends Base {
	
	//每月每天的注册量
	public function getMonthDayUser($date = '') {
		if ($date == '') {
			$date = date ( 'Y-m' );
		}
		$_mTotal = date ( 't', strtotime ( $date ) );
		$_oneDay = $date . '-01 00:00:00';
		$_endDay = $date . '-' . $_mTotal . ' 23:59:59';
		$w = " uCreateDate>='{$_oneDay}' and uCreateDate<='{$_endDay}' ";
		$obj = D ( 'Users' );
		$obj->setField ( 'id,uCreateDate' );
		$res = $obj->getUsers ( $w );
		$_tmpRes = array ();
		foreach ( $res as $k => $v ) {
			$_tmpD = intval ( date ( 'd', strtotime ( $v ['uCreateDate'] ) ) );
			if (! isset ( $_tmpRes [$_tmpD] )) {
				$_tmpRes [$_tmpD] = 0;
			}
			$_tmpRes [$_tmpD] = intval ( $_tmpRes [$_tmpD] ) + 1;
		}
		for($i = 1; $i <= $_mTotal; $i ++) {
			if (! isset ( $_tmpRes [$i] )) {
				$_tmpRes [$i] = 0;
			}
		}
		ksort ( $_tmpRes );
		return json_encode ( $_tmpRes );
	}
	
	//每人每天的保险单量
	public function getInsDayService($_date = '') {
		$sObj = new SerMemberModel ();
		$sRes = $sObj->getSerMember ();
		$_tmpSRes = array ();
		
		$iObj = new InsModel ();
		$iObj->setField ( 'count(id) as total' );
		if ($_date == '') {
			$_date = date ( 'Y-m-d' );
		}
		$_nDate = date ( 'Y-m-d', strtotime ( "+1 day", strtotime ( $_date ) ) );
		$_tmpIRes = array ();
		
		foreach ( $sRes as $k => $v ) {
			$_tmpSRes [] = $v ['sName'];
			$w = " iCreateDate>='{$_date}' and  iCreateDate<'{$_nDate}' and smIdOne='{$v['id']}' ";
			$tmpRes = $iObj->getIns ( $w, '', '', '1' );
			$_tmpIRes [] = $tmpRes ['total'];
		}
		return array ('x' => $_tmpSRes, 'y' => $_tmpIRes );
	}
	
	//绑定用户与非绑定用户
	public function getInsSyncUser() {
		$insObj = new InsModel ();
		$insObj->setField ( 'count(id) as total' );
		//绑定用户
		$w = ' iUserId<>"" ';
		$res = $insObj->getIns ( $w, '', '', '1' );
		//非绑定用户 
		$w = ' iUserId="" ';
		$noRes = $insObj->getIns ( $w, '', '', '1' );
		return array ('syncNum' => $res ['total'], 'syncNoNum' => $noRes ['total'] );
	}
	
	//每天签到人数统计
	public function getSignDayUser($date = '') {
		if ($date == '') {
			$date = date ( 'Y-m' );
		}
		$y = date('Y');
		$_mTotal = date ( 't', strtotime ( $date ) );
		$_oneDay = $y.'-'.$date . '-01';
		$_endDay = $y.'-'.$date . '-' . $_mTotal;
		$w = " sDate>='{$_oneDay}' and sDate<='{$_endDay}' ";
		$obj = new SignMainRecordModel();
		$obj->setField ( 'id,sDate' );
		$res = $obj->getSignMainRecord ( $w );
		$_tmpRes = array ();
		foreach ( $res as $k => $v ) {
			$_tmpD = intval ( date ( 'd', strtotime ( $v ['sDate'] ) ) );
			if (! isset ( $_tmpRes [$_tmpD] )) {
				$_tmpRes [$_tmpD] = 0;
			}
			$_tmpRes [$_tmpD] = intval ( $_tmpRes [$_tmpD] ) + 1;
		}
		for($i = 1; $i <= $_mTotal; $i ++) {
			if (! isset ( $_tmpRes [$i] )) {
				$_tmpRes [$i] = 0;
			}
		}
		ksort ( $_tmpRes );
		return json_encode ( $_tmpRes );
	}
}