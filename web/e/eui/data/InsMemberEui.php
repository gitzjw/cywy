<?php
final class InsMemberEuiController extends Base {
	
	public function getInsMemberList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new InsMemberModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getInsMember ( $w, 'iCreateDate desc', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getInsMember ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_idCard = Run::req ( '_idcard' );
		$_tel = Run::req ( '_tel' );
		$_xm = Run::req ( '_xm' );
		$_uid = Run::req ( '_uid' );
		if (! $_idCard && ! $_tel && ! $_xm && ! $_uid) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_idCard) {
			$w .= ' and iIdCard="' . $_idCard . '" ';
		}
		if ($_tel) {
			$w .= ' and iTelNumber="' . $_tel . '" ';
		}
		if ($_xm) {
			$w .= ' and iName="' . $_xm . '" ';
		}
		if ($_uid) {
			$w .= ' and iUserId="' . $_uid . '" ';
		}
		return $w;
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
	
	public function getInsMemberAllSelect() {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ();
		$_name = Run::req ( 'name' );
		$_name = $_name ? $_name : 'iInsuerId';
		$_html = '<select name="' . $_name . '">';
		foreach ( $res as $k => $v ) {
			$_html .= '<option value="' . $v ['id'] . '">' . $v ['iName'] . '</option>';
		}
		$_html .= '</select>';
		echo $_html;
	}
	
	public function getInsMemberDisAllSelect() {
		$obj = D ( 'InsMember' );
		$res = $obj->getInsMember ( ' id NOT IN (SELECT iInsuerId FROM insurance ) ' );
		$_name = Run::req ( 'name' );
		$_name = $_name ? $_name : 'iInsuerId';
		$_html = '<select name="' . $_name . '">';
		foreach ( $res as $k => $v ) {
			$_html .= '<option value="' . $v ['id'] . '">' . $v ['iName'] . '</option>';
		}
		$_html .= '</select>';
		echo $_html;
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
		$_html = '';
		$obj = D ( 'InsMember' );
		$_uid = Run::req ( 'uid' );
		$res = $obj->getInsMember ( "iUserId='{$_uid}'", '', '1', '1' );
		if (! empty ( $res )) {
			$_sex = $res ['iSex'] == '0' ? '女' : '男';
			$_html .= "<h3>姓名：{$res['iName']}</h3><h3>性别：{$_sex}</h3><h3>身份证：{$res['iIdCard']}</h3><h3>电话：{$res['iTelNumber']}</h3><h3>地址：{$res['iAddress']}</h3>";
		}
		$_html .= '';
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
			echo '请输入姓名';
			exit ();
		}
		$_d ['iIdCard'] = Run::req ( 'iIdCard' );
		if ($_d ['iIdCard'] == '' || strlen ( $_d ['iIdCard'] ) > 18 || strlen ( $_d ['iIdCard'] ) < 16) {
			echo '请输入正确的身份证号';
			exit ();
		}
		
		$_year = date ( 'Y', time () );
		$_oYear = date ( 'Y', strtotime ( Run::getIdCardBirthday ( $_d ['iIdCard'] ) ) );
		
		$_d ['iSex'] = Run::getIdCardSex ( $_d ['iIdCard'] );
		$_d ['iAge'] = $_year - $_oYear;
		$_d ['iTelNumber'] = Run::req ( 'iTelNumber' );
		if ($_d ['iTelNumber'] == '') {
			echo '请输入联系电话';
			exit ();
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
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
		
	//查询服务人员
	public function getSerMemberNameAll() {
		$obj = new SerMemberModel ();
		$res = $obj->getSerMember ();
		$newRes = array ();
		foreach ( $res as $k => $v ) {
			$newRes [$v ['sName']] = $v;
		}
		return $newRes;
	}
	
	//导入保单人员
	public function importMember() {
		
		$_f_id = Run::req('id');
		$insFObj = new InsImportFileModel();
		$insFRes = $insFObj->getInsImportFile('id="'.$_f_id.'"','','1','1');
		if(!$insFRes){
			echo '没有查询到相关文件';exit;
		}
		$insFRes['status']='2';
		$insFObj->setInsImportFile($_f_id,$insFRes);
		
		$hd = fopen ( APP_PATH . $insFRes['filePath'], 'r' );
		$data = array ();
		while ( ! feof ( $hd ) ) {
			$data [] = fgets ( $hd );
		}
		fclose ( $hd );
		
		$serRes = $this->getSerMemberNameAll ();
		
		$sObj = D ( 'InsMember' );
		$insObj = new InsModel ();
				
		foreach ( $data as $k => $v ) {
			$_tmp = explode ( '	', $v );
			$_d ['iName'] = trim($_tmp ['1']);
			$_d ['iSex'] = trim($_tmp ['2']) == '男' ? '1' : '0';
			$_d ['iAge'] = trim($_tmp ['3']);
			$_d ['iIdCard'] = trim($_tmp ['4']);
			$_d ['iTelNumber'] = trim($_tmp ['5']);
			$_d ['iAddress'] = trim($_tmp ['0']);
			$_d ['iUserId'] = '';
			$_d ['iCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
			$_d ['iuStatus'] = '1';
			$_d ['id'] = $this->importSysid ();
			$res = $sObj->addInsMember ( $_d );
			
			$_serId = isset ( $serRes [trim($_tmp [8])] ) ? $serRes [trim($_tmp [8])] ['id'] : '1';
			
			$this->importIns ( $_tmp, $_d ['id'], $insObj, $_serId );			
		}
		echo $k.'记录';
	}
	
	//导入保险信息
	public function importIns($value, $i_id, $insObj, $_serId) {
		$dataArray ['id'] = $this->importSysid ();
		$dataArray ['iInsId'] = trim($value [9]);
		$dataArray ['wType'] = '5';
		$dataArray ['smIdOne'] = $_serId;
		$dataArray ['smIdTwo'] = '17';
		$dataArray ['iStart'] = trim($value [6]);
		$dataArray ['iEnd'] = trim($value [7]);
		$dataArray ['iStatus'] = '1';
		$dataArray ['iUserId'] = '';
		$dataArray ['iInsuerId'] = $i_id;
		$dataArray ['iCreateDate'] = date ( 'Y-m-d H:i:s' );
		$dataArray ['iUpdateDate'] = '';
		$insObj->addIns($dataArray);
		return true;
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