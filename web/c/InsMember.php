<?php
final class InsMemberController extends Base {
	
	public function getInsMemberList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getInsMemberAllCount() {
		$obj = D ( 'InsMember' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getInsMember ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getInsMemberAll() {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ();
		$newRes = array ();
		foreach ( $res as $k => $v ) {
			$newRes [$v ['id']] = $v;
		}
		return $newRes;
	}
	
	public function getInsMemberDisAll() {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ( ' id NOT IN (SELECT iInsuerId FROM insurance ) ' );
		$newRes = array ();
		foreach ( $res as $k => $v ) {
			$newRes [$v ['id']] = $v;
		}
		return $newRes;
	}
	
	public function getInsMemberId($_id) {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsMemberName($_n) {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ( "iName='{$_n}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsMemberIdCard($idcard) {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ( "iIdCard='{$idcard}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsMemberUserIdHtml() {
		$_html = '<article class="module width_3_quarter">
						<header>
							<h3 class="tabs_involved" id="detail_h3">用户个人信息详细</h3>	
						</header>
						<div id="html_div">';
		$obj = D ( 'InsMember' );
		$_uid = Run::req ( 'uid' );
		$res = $obj->getInsMember ( "iUserId='{$_uid}'", '', '1', '1' );
		if (! empty ( $res )) {
			$_sex = $res ['iSex'] == '0' ? '女' : '男';
			$_html .= "<h3>姓名：{$res['iName']}</h3><h3>性别：{$_sex}</h3><h3>身份证：{$res['iIdCard']}</h3><h3>电话：{$res['iTelNumber']}</h3><h3>地址：{$res['iAddress']}</h3>";
		}
		$_html .= '</div>
						<footer>
							<div class="submit_link">
							</div>
						</footer>
					</article>';
		echo $_html;
	}
	
	public function updateInsMember($id, $data) {
		$sObj = D ( 'InsMember' );
		$res = $sObj->setInsMember ( $id, $data );
		return $res;
	}
	
	public function saveInsMember() {
		$_id = Run::req ( 'id' );
		
		$_d ['iName'] = Run::req ( 'iName' );
		if ($_d ['iName'] == '') {
			Run::show_msg ( '请输入姓名' );
		}
		$_d ['iIdCard'] = Run::req ( 'iIdCard' );
		if ($_d ['iIdCard'] == '' || strlen ( $_d ['iIdCard'] ) > 18 || strlen ( $_d ['iIdCard'] ) < 16) {
			Run::show_msg ( '请输入身份证' );
		}
		
		$_year = date ( 'Y', time () );
		$_oYear = date ( 'Y', strtotime ( Run::getIdCardBirthday ( $_d ['iIdCard'] ) ) );
		
		$_d ['iSex'] = Run::getIdCardSex ( $_d ['iIdCard'] );
		$_d ['iAge'] = $_year - $_oYear;
		$_d ['iTelNumber'] = Run::req ( 'iTelNumber' );
		if ($_d ['iTelNumber'] == '') {
			Run::show_msg ( '请输入联系电话' );
		}
		$_d ['iAddress'] = Run::req ( 'iAddress' );
		$_d ['iUserId'] = Run::req ( 'iUserId' );
		$_d ['iCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$_d ['iuStatus'] = Run::req ( 'iuStatus' );
		
		$sObj = D ( 'InsMember' );
		if ($_id) {
			$res = $sObj->setInsMember ( $_id, $_d );
		} else {
			$_d ['id'] = $this->Sysid ();
			$res = $sObj->addInsMember ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=insurance.member' );
		}
	}
	
	public function importMember() {
		exit ();
		$hd = fopen ( __DIR__ . '/../public/file/import.1.txt', 'r' );
		$data = array ();
		while ( ! feof ( $hd ) ) {
			$data [] = fgets ( $hd );
		}
		fclose ( $hd );
		$sObj = D ( 'InsMember' );
		
		foreach ( $data as $k => $v ) {
			$_tmp = explode ( '	', $v );
			$_d ['iName'] = $_tmp ['1'];
			$_d ['iSex'] = $_tmp ['2'] == '男' ? '1' : '0';
			$_d ['iAge'] = $_tmp ['3'];
			$_d ['iIdCard'] = $_tmp ['4'];
			$_d ['iTelNumber'] = $_tmp ['5'];
			$_d ['iAddress'] = $_tmp ['0'];
			$_d ['iUserId'] = '';
			$_d ['iCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
			$_d ['iuStatus'] = '1';
			$_d ['id'] = $this->Sysid ();
			$res = $sObj->addInsMember ( $_d );
			echo $k, '<br/>';
		}
	}
	
	public function delInsMember() {
		$_id = Run::req ( 'id' );
		$sObj = D ( 'InsMember' );
		$res = $sObj->delInsMember ( $_id );
		if ($res) {
			echo 1;
		} else {
			echo 0;
		}
	}

}