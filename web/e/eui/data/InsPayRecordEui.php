<?php
final class InsPayRecordEuiController extends Base {
	
	public function getInsPayRecordPidList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$aeObj = new InsPayRecordModel ();
		$_pid = Run::req('_pid');
		$res = $aeObj->getInsPayRecordPid($_pid);
		$_tmpRes = array ('total' => '10', 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	public function getInsPayRecordId($_id) {
		$obj = D ( 'InsPayRecord' );
		$res = $obj->getInsPayRecord ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsPayRecordPid($_pid) {
		$obj = D ( 'InsPayRecord' );
		$res = $obj->getInsPayRecord ( "pId='{$_pid}'" );
		return $res;
	}
	
	public function updateInsPayRecordPid($_pid, $_s = '1') {
		$obj = D ( 'InsPayRecord' );
		$data ['rStatus'] = $_s;
		$res = $obj->setInsPayRecordPid ( $_pid, $data );
		return $res;
	}
	
	public function seeInsPayRecordDetail() {
		$_pid = Run::req ( 'id' );
		$obj = D ( 'InsPayRecord' );
		$res = $obj->getInsPayRecordPid ( $_pid );
		if (empty ( $res )) {
			echo '0';
		} else {
			echo json_encode ( $res );
		}
	}

}