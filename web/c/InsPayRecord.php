<?php
final class InsPayRecordController extends Base {
	
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