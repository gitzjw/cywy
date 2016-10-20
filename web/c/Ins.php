<?php
final class InsController extends Base {
	
	public function getInsList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'Ins' );
		$res = $obj->getIns ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getInsAllCount() {
		$obj = D ( 'Ins' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getIns ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getInsId($_id) {
		$obj = D ( 'Ins' );
		$res = $obj->getIns ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function getInsUsersId($_id) {
		$obj = D ( 'Ins' );
		$res = $obj->getInsUsersIdUnionData ( $_id );
		return $res;
	}
	
	public function getInsInsuerId($_id) {
		$obj = D ( 'Ins' );
		$res = $obj->getIns ( "iInsuerId='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function updateIns($id, $data) {
		$sObj = D ( 'Ins' );
		$data ['iUpdateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$res = $sObj->setIns ( $id, $data );
		return $res;
	}
	
	public function saveIns() {
		$_id = Run::req ( 'id' );
		
		$_d ['iSpan'] = Run::req ( 'iSpan' );
		$_d ['iInsId'] = Run::req ( 'iInsId' );
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['smIdOne'] = Run::req ( 'smIdOne' );
		$_d ['smIdTwo'] = Run::req ( 'smIdTwo' );
		$_d ['iStart'] = Run::req ( 'iStart' );
		$_dateEnd = date ( "Y-m-d H:i:s", strtotime ( "-1 day", strtotime ( "+{$_d ['iSpan']} months", strtotime ( $_d ['iStart'] ) ) ) );
		$_d ['iEnd'] = $_dateEnd;
		$_d ['iStatus'] = Run::req ( 'iStatus' );
		$_d ['iUserId'] = Run::req ( 'iUserId' );
		$_d ['iInsuerId'] = Run::req ( 'iInsuerId' );
		
		if(empty($_d['iSpan'])){
			$_d['iSpan'] = 0;
		}

		$sObj = D ( 'Ins' );
		if ($_id) {
			$_d ['iUpdateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
			$res = $sObj->setIns ( $_id, $_d );
		} else {
			$_d ['id'] = $this->Sysid ();
			$_d ['iCreateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
			$_d ['iUpdateDate'] = '2000-01-01 01:00:00';
			$res = $sObj->addIns ( $_d );
		}
		
		if ($res) {
			Run::show_msg ( '操作成功', '1', APP_WEBSITE . 'e/adm/?v=insurance' );
		}
	}
	
	public function delIns() {
		$_id = Run::req ( 'id' );
		$sObj = D ( 'Ins' );
		$res = $sObj->delIns ( $_id );
		if ($res) {
			echo 1;
		} else {
			echo 0;
		}
	}
	
	public function messageIns() {
		$_id = Run::req ( 'id' );
		$_msgType = Run::req('msgtype');
		$res = $this->getInsId ( $_id );
		if (empty ( $res )) {
			echo '0';
			exit ();
		} else {
			$obj = new InsMemberController ();
			$iuRes = $obj->getInsMemberId ( $res ['iInsuerId'] );
			$_tmpSex = $iuRes ['iSex'] == '1' ? '先生' : '女士';
			$_tmpName = substr ( $iuRes ['iName'], 0, 3 );
			switch ($_msgType){
				case '1':
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，您投保的宠物行业从业者综合意外医疗保险，已生效。从此您的工作、生活有了全面保障，保单查询、出险理赔请关注宠业无忧微信公号。回N退订';
					break;
				case '2':
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，对于您此次出险，宠业无忧全体员工为您带来最真挚的慰问，希望您及时就医，早日康复！回N退订';
					break;
				case '3':
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，有些事情可能您已经忘记，但我们依然记得。今天是您的生日， 萌公社全体员工恭祝您生日快乐！愿您开开心心每一天 :-)。回N退订';
					break;
				default:
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，您投保的宠物行业从业者综合意外医疗保险，已生效。从此您的工作、生活有了全面保障，保单查询、出险理赔请关注宠业无忧微信公号。回N退订';
					break;
			}			
			$mgsRes = Run::sendMessage ( trim($iuRes ['iTelNumber']), $info, '0' );
			if ($mgsRes == '00') {
				echo 1;
				exit ();
			} else {
				echo $mgsRes;
				exit ();
			}
		}
	}

}