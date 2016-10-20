<?php
final class SignMainEuiController extends Base {
	
	public function getSignMainList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new SignMainModel();
		$w = $this->getWhere ();
		$ueObj->setField ( '*' );
		$res = $ueObj->getSignMain ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getSignMain ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_uid = Run::req ( '_uid' );
		if (! $_uid) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_uid) {
			$w .= ' and uId="' . $_uid . '" ';
		}
		return $w;
	}
	
	public function getSignMainAllCount() {
		$obj = D ( 'SignMain' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getSignMain ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	//查询某个签到用户
	public function findSignMainUid($uid = '') {
		if (empty ( $uid )) {
			$uD = $this->getUserDetail ();
			$uid = $uD ['id'];
		}
		$obj = D ( 'SignMain' );
		$w = " uId='{$uid}' ";
		$res = $obj->getSignMain ( $w, '', '1', '1' );
		if (! $res) {
			//如果没有数据，则添加一条用户数据
			$this->addSignMain ();
			$res = $obj->getSignMain ( $w, '', '1', '1' );
		}
		return $res;
	}
	
	//添加签到用户
	public function addSignMain() {
		$uD = $this->getUserDetail ();
		if (! $uD) {
			return false;
		}
		$obj = D ( 'SignMain' );
		$data ['uId'] = $uD ['id'];
		$data ['mTotalNum'] = '0';
		$data ['mContNum'] = '0';
		$data ['sTotalNum'] = '0';
		$data ['sContNum'] = '0';
		$res = $obj->addSignMain ( $data );
		return $res;
	}
	
	//更新签到用户
	public function updateSignMain($data) {
		$obj = D ( 'SignMain' );
		$res = $obj->setSignMain ( $data ['id'], $data );
		return $res;
	}
	
	//日历
	public function displayCalendar($date = '') {
		$obj = new SignMainRecordController ();
		$mRes = $obj->findUserMonthRecord ();		
		$_tmpNewArr = array ();
		foreach ( $mRes as $k => $v ) {
			$_tmpNewArr [$v ['sDate']] = $v;
		}
		
		if ($date == '') {
			$date = date ( 'Y-m' );
		}
		$_oneWeek = date ( 'w', strtotime ( $date . '-01' ) );
		$_mTotal = date ( 't', strtotime ( $date ) );
		$_arrDate = array ('日', '一', '二', '三', '四', '五', '六' );
		$_tmpInt = $_oneWeek;
		$_tmpIntTwo = 1;
		$_html = '<tr>
					<th>日</th>
					<th>一</th>
					<th>二</th>
					<th>三</th>
					<th>四</th>
					<th>五</th>
					<th>六</th>
				</tr>';
		for($i = 1; $i <= $_mTotal; $i ++) {
			if ($_tmpIntTwo == 1) {
				$_html .= '<tr>';
				$_html .= str_repeat ( '<td></td>', $_tmpInt );
				for($j = $_tmpInt; $j <= 6; $j ++) {
					if ($i > 10) {
						$_tmpDate = $date . '-' . $i;
					} else {
						$_tmpDate = $date . '-0' . $i;
					}
					if (isset ( $_tmpNewArr [$_tmpDate] ) && ! empty ( $_tmpNewArr [$_tmpDate] )) {
						$_clsStr = 'class="sign_active"';
					} else {
						$_clsStr = '';
					}
					$_html .= '<td ' . $_clsStr . '>' . $i . '</td>';
					$i ++;
				}
				$_html .= '</tr>';
				$i --;
				$_tmpIntTwo = 0;
			} else {
				$_html .= '<tr>';
				for($j = 0; $j <= 6; $j ++) {
					if ($i > $_mTotal) {
						$_html .= '<td></td>';
					} else {
						if ($i > 10) {
							$_tmpDate = $date . '-' . $i;
						} else {
							$_tmpDate = $date . '-0' . $i;
						}
						if (isset ( $_tmpNewArr [$_tmpDate] ) && ! empty ( $_tmpNewArr [$_tmpDate] )) {
							$_clsStr = 'class="sign_active"';
						} else {
							$_clsStr = '';
						}
						$_html .= '<td ' . $_clsStr . '>' . $i . '</td>';
					}
					$i ++;
				}
				$_html .= '</tr>';
				$i --;
			}
		}
		return $_html;
	}

}