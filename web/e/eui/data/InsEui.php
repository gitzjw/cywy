<?php
final class InsEuiController extends Base {
	
	public function getInsList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new InsModel ();
		$w = $this->getWhere ();
		$ueObj->setField ( '*,(select sName from website_type w where w.id=wType) as wTypeName,(select iName from insurance_member im where im.id=iInsuerId) as iName ' );
		$res = $ueObj->getIns ( $w, 'iCreateDate desc', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getIns ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_end = Run::req ( '_end' );
		$_start = Run::req ( '_start' );
		$_xm = Run::req ( '_xm' );
		$_uid = Run::req ( '_uid' );
		if (! $_end && ! $_start && ! $_xm && ! $_uid) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_end) {
			$_date_n = strtotime ( $_end );
			$_date = date ( 'Y-m-d', strtotime ( "+1 day", $_date_n ) );
			$w .= ' and iEnd<"' . $_date . '" ';
		}
		if ($_start) {
			$_date_n = strtotime ( $_start );
			$_date = date ( 'Y-m-d', strtotime ( "-1 day", $_date_n ) );
			$w .= ' and iTelNumber>"' . $_date . '" ';
		}
		if ($_xm) {
			$obj = new InsMemberModel ();
			$_tmp = $obj->getInsMember ( ' iName="' . $_xm . '" ', '', '1', '1' );
			if ($_tmp) {
				$w .= ' and iInsuerId="' . $_tmp ['id'] . '" ';
			} else {
				$w .= ' and iInsuerId="" ';
			}
		}
		if ($_uid) {
			$w .= ' and iUserId="' . $_uid . '" ';
		}
		return $w;
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
	
	public function updateInsStatus() {
		$_id = Run::req ( 'id' );
		$sObj = D ( 'Ins' );
		$data ['iStatus'] = Run::req ( '_s' );
		$data ['iUpdateDate'] = Run::getFormatDate ( '', 'Y-m-d H:i:s' );
		$res = $sObj->setIns ( $_id, $data );
		if ($res) {
			echo 1;
			exit ();
		} else {
			echo '';
			exit ();
		}
	}
	
	public function saveIns() {
		$_id = Run::req ( 'id' );
		
		$_d ['iSpan'] = Run::req ( 'iSpan' );
		$_d ['iInsId'] = Run::req ( 'iInsId' );
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['smIdOne'] = Run::req ( 'smIdOne' );
		$_d ['smIdTwo'] = Run::req ( 'smIdTwo' );
		$_dateStart = date ( 'Y-m-d H:i:s', strtotime ( Run::req ( 'iStart' ) ) );
		$_d ['iStart'] = $_dateStart;
		$_dateEnd = date ( "Y-m-d H:i:s", strtotime ( "-1 day", strtotime ( "+{$_d ['iSpan']} day", strtotime ( $_d ['iStart'] ) ) ) );
		$_d ['iEnd'] = $_dateEnd;
		$_d ['iStatus'] = Run::req ( 'iStatus' );
		$_d ['iUserId'] = Run::req ( 'iUserId' );
		$_d ['iInsuerId'] = Run::req ( 'iInsuerId' );

		
		
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
			echo '操作成功';
		} else {
			echo '操作失败';
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
		$_msgType = Run::req ( 'msgtype' );
		$res = $this->getInsId ( $_id );
		if (empty ( $res )) {
			echo '0';
			exit ();
		} else {
			$obj = new InsMemberController ();
			$iuRes = $obj->getInsMemberId ( $res ['iInsuerId'] );
			$_tmpSex = $iuRes ['iSex'] == '1' ? '先生' : '女士';
			$_tmpName = substr ( $iuRes ['iName'], 0, 3 );
			switch ($_msgType) {
				case '1' :
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，您投保的宠物行业从业者综合意外医疗保险，已生效。从此您的工作、生活有了全面保障，保单查询、出险理赔请关注宠业无忧微信公号。回N退订';
					break;
				case '2' :
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，对于您此次出险，宠业无忧全体员工为您带来最真挚的慰问，希望您及时就医，早日康复！回N退订';
					break;
				case '3' :
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，有些事情可能您已经忘记，但我们依然记得。今天是您的生日， 宠业无忧全体员工恭祝您生日快乐！愿您开开心心每一天 :-)。回N退订';
					break;
				case '4' :
					$info = '【宠业无忧】您的宠物行业从业者意外医疗保险，即将到期。使用宠业无忧 商品供应链服务，宠物店内全员即可免费无限期延保，详情询4007-007-580 回N退订';
					break;
				default :
					$info = '【宠业无忧】亲爱的' . $_tmpName . $_tmpSex . '，您投保的宠物行业从业者综合意外医疗保险，已生效。从此您的工作、生活有了全面保障，保单查询、出险理赔请关注宠业无忧微信公号。回N退订';
					break;
			}
			$mgsRes = Run::sendMessage ( trim ( $iuRes ['iTelNumber'] ), $info, '0' );
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