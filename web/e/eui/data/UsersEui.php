<?php
final class UsersEuiController extends Base {
	
	public function getUsersList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new UsersModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getUsers ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getUsers ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_idCard = Run::req ( '_idcard' );
		$_tel = Run::req ( '_tel' );
		$_id = Run::req ( '_id' );
		if (! $_idCard && ! $_tel && ! $_id) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_idCard) {
			$w .= ' and idCard="' . $_idCard . '" ';
		}
		if ($_tel) {
			$w .= ' and telNumber="' . $_tel . '" ';
		}
		if ($_id) {
			$w .= ' and id="' . $_id . '" ';
		}
		return $w;
	}
	
	public function saveIdCardAndTel() {
		$_id = Run::req ( 'id' );
		if (empty ( $_id )) {
			echo '操作失败，没有用户';
			exit ();
		}
		$_d ['idCard'] = Run::req ( 'idcard' );
		$idcardCheckRes = $this->isIdCardNo ( $_d ['idCard'] );
		if (! $idcardCheckRes) {
			echo '身份证号错误';
			exit ();
		}
		$_d ['telNumber'] = Run::req ( 'tel' );
		if (strlen ( $_d ['telNumber'] ) != '11') {
			echo '手机号错误';
			exit ();
		}
		
		$obj = new UsersModel ();
		$res = $obj->getUsers ( 'id="' . $_id . '"', '', '1', '1' );
		if (empty ( $res )) {
			echo '操作失败，没有用户';
			exit ();
		} else {
			$_d['uCreateDate']=$res['uCreateDate'];
			$obj->setUsers ( $_id, $_d );
			echo '操作成功';
			exit ();
		}
	}

}