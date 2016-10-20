<?php
final class AdminController extends Base {
	
	public function getAdminUsersList() {
		$_p = Run::req ( 'page' );
		$_page = intval ( $_p ) * 10;
		$limit = $_page . ',10';
		$obj = D ( 'Admin' );
		$res = $obj->getAdminUsers ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getAdminUsersId($_id) {
		$obj = D ( 'Admin' );
		$res = $obj->getAdminUsers ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function loginAdminUsers() {
		$_an = Run::req ( 'uname' );
		$_aw = Run::req ( 'pwd' );
		$obj = D ( 'Admin' );
		$res = $obj->getAdminUsers ( " uName='{$_an}' and uPwd='{$_aw}' and uStatus='1' ", '', '1', '1' );
		if (empty ( $res )) {
			Run::show_msg ( '用户名或密码错误', '1' );
		} else {
			$_SESSION [APP_NAME . '_admin_'] = $res;
			Run::show_msg ( null, '1', '?v=index' );
		}
	}
	
	public function checkUName($_name){
		$obj = D ( 'Admin' );
		$res = $obj->getAdminUsers ( " uName='{$_name}' ", '', '1', '1' );
		if (empty ( $res )) {
			return true;
		} else {
			Run::show_msg ( '用户名已经存在', '', APP_WEBSITE . 'e/adm/?v=users.admin.add' );
		}
	}
	
	public function saveAdminUsers() {
		$_id = Run::req ( 'id' );
		
		$_d ['uName'] = Run::req ( 'uName' );
		$_d ['uPwd'] = Run::req ( 'uPwd' );
		$_d ['uType'] = Run::req ( 'uType' );
		$_d ['uStatus'] = Run::req ( 'uStatus' );
		
		$sObj = D ( 'Admin' );
		if ($_id) {
			$res = $sObj->setAdminUsers ( $_id, $_d );
		} else {
			$this->checkUName($_d['uName']);
			$res = $sObj->addAdminUsers ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=users.admin' );
		}
	}

}