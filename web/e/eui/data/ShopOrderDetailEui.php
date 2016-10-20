<?php
final class ShopOrderDetailEuiController extends Base {
	
	public function getShopOrderDetailOidList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopOrderDetailModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopOrderDetail ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopOrderDetail ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_oid = Run::req ( '_oid' );
		if (! $_oid) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_oid) {
			$w .= ' and oId="' . $_oid . '" ';
		}
		return $w;
	}
	
	public function getShopOrderHistory() {
		$_oid = Run::req ( '_oid' );
		$obj = new ShopOrderHistoryModel ();
		$res = $obj->getShopOrderHistory ( ' oId="' . $_oid . '" ' );
		$_html = '';
		foreach ( $res as $k => $v ) {
			$_html .= '<h3>操作时间：' . $v ['createTime'] . ' 操作人：' . $v ['oUser'] . ' 接收人：' . $v ['rUser'] . ' 状态：' . $this->getStatus ( $v ['oStatus'] ) . ' 用户：' . $v ['uId'] . ' </h3>';
		}
		echo $_html;
	}
	
	private function getStatus($_s = '') {
		$_str = '';
		switch ($_s) {
			case '1' :
				$_str = '<b style="color:C0C0C0">订单创建成功</b>';
				break;
			case '2' :
				$_str = '<b style="color:#DAA520">订单已确认，待配送</b>';
				break;
			case '3' :
				$_str = '<b style="color:#696969">订单已取消</b>';
				break;
			case '4' :
				$_str = '<b style="color:#D2691E">订单配送中</b>';
				break;
			case '5' :
				$_str = '<b style="color:#00FF00">收款成功</b>';
				break;
			case '6' :
				$_str = '<b style="color:#008000">订单已完成</b>';
				break;
			case '7' :
				$_str = '<b style="color:#FF0000">退货申请中</b>';
				break;
			case '8' :
				$_str = '<b style="color:#B22222">退货成功</b>';
				break;
			default :
				$_str = '<b style="color:#90EE90">订单创建成功</b>';
				break;
		}
		return $_str;
	}

}