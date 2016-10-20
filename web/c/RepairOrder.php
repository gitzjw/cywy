<?php
final class RepairOrderController extends Base {
	
	public function getRepairOrderList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = intval ( $_p ) * Run::$PAGE_ADMIN;
		$limit = $_page . ',' . Run::$PAGE_ADMIN;
		$obj = D ( 'RepairOrder' );
		$res = $obj->getRepairOrder ( '', '', $limit );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	public function getRepairOrderAllCount() {
		$obj = D ( 'RepairOrder' );
		$obj->setField ( ' count(id) as total ' );
		$res = $obj->getRepairOrder ( '', '', '', '1' );
		if (empty ( $res )) {
			return 0;
		}
		return intval ( $res ['total'] );
	}
	
	public function getRepairOrderUid($_uid) {
		$obj = D ( 'RepairOrder' );
		$res = $obj->getRepairOrder ( "uId='{$_uid}'", '', '', '' );
		return $res;
	}
	
	public function getRepairOrderId($_id) {
		$obj = D ( 'RepairOrder' );
		$res = $obj->getRepairOrder ( "id='{$_id}'", '', '1', '1' );
		return $res;
	}
	
	public function setRepairOrder($data) {
		$obj = D ( 'RepairOrder' );
		$res = $obj->setRepairOrder ( $data ['id'], $data );
		return $res;
	}
	
	public function getOrderStatus($_s = '1') {
		$_str = '';
		switch ($_s) {
			case '1' :
				$_str = '订单已创建';
				break;
			case '2' :
				$_str = '订单支付成功';
				break;
			case '3' :
				$_str = '已经发送物流';
				break;
			case '9' :
				$_str = '订单完成';
				break;
			default :
				$_str = '订单已创建';
				break;
		}
		return $_str;
	}
	
	public function getRepairOrderHtml() {
		$_html = '<article class="module width_3_quarter">
						<header>
							<h3 class="tabs_involved" id="detail_h3">用户个人信息详细</h3>	
						</header>
						<div id="html_div">';
		
		$_oid = Run::req ( 'oid' );
		$res = $this->getRepairOrderId ( $_oid );
		
		if (! empty ( $res )) {
			$_html .= "<h3>邮寄地址：{$res['mAddress']}</h3><h3>回寄地址：{$res['bAddress']}</h3><h3>上门地址：{$res['cAddress']}</h3><h3>物流详细：{$res['roExpContent']}</h3>";
		}
		$_html .= '</div>
						<footer>
							<div class="submit_link">
							</div>
						</footer>
					</article>';
		echo $_html;
	}
	
	public function updateRepairOrderExpNum() {
		$_id = Run::req ( 'id' );
		$res = $this->getRepairOrderId ( $_id );
		if (! $res) {
			Run::show_msg ( '保存失败，订单号错误' );
		}
		
		$_expnum = Run::req ( 'roExpNum' );
		
		if (! $_expnum) {
			Run::show_msg ( '请填写物流单号' );
		}
		
		if ($res ['roStatus'] < 3) {
			$odObj = new RepairOrderDetailController ();
			$odRes = $odObj->updateRepairOrderDetailStatus ( $_id, '3' );
			
			$ropObj = new RepairPayController ();
			$ropObj->createRepairOrderHistory ( $res, '3' );
		}
		
		$_expcontent = Run::req ( 'roExpContent' );
		$res ['roStatus'] = '3';
		$res ['roExpNum'] = $_expnum;
		$res ['roExpContent'] = $_expcontent;
		$obj = new RepairOrderModel ();
		$upRes = $obj->setRepairOrder ( $_id, $res );
		Run::show_msg ( '更新成功' );
	}

}