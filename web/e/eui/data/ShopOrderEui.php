<?php
final class ShopOrderEuiController extends Base {
	
	public function getShopOrderList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopOrderModel ();
		$w = $this->getWhere ();
		$res = $ueObj->getShopOrder ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopOrder ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_idCard = Run::req ( '_idcard' );
		$_tel = Run::req ( '_tel' );
		$_id = Run::req ( '_id' );
		$_uid = Run::req ( '_uid' );
		$_start = Run::req ( '_start' );
		$_end = Run::req ( '_end' );
		$_status = Run::req('_status');
		$_city = Run::req('_city');
		if (! $_idCard && ! $_tel && ! $_id && ! $_uid && !$_start && !$_end && !$_status && !$_city) {
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
		if ($_uid) {
			$w .= ' and uId="' . $_uid . '" ';
		}
		if($_start){
			$w .= ' and createTime>="'.$_start.'" ';
		}
		if($_end){
			$w .= ' and createTime<="'.$_end.'" ';
		}
		if($_status){
			$w .= ' and oStatus="'.$_status.'" ';
		}
		if($_city){
			$w .= ' and city="'.$_city.'" ';
		}
		return $w;
	}
	
	//查询今日生效的订单
	public function getShopOrderValid() {
		$_city = Run::req('_city');
		$obj = new ShopOrderModel ();
		$w = 'oStatus="2" and city="'.$_city.'"';
		$res = $obj->getShopOrder ( $w );
		if (empty ( $res )) {
			return array ();
		}
		return $res;
	}
	
	//查询产品
	public function getShopProDetail($_id = '',$city = '') {
		$obj = new ShopProModel ();
		$obj->setTableCity($city);
		$obj->setField ( 'sNorms,sUnit' );
		$res = $obj->getShopPro ( 'id="' . $_id . '"', '', '1', '1' );
		return $res;
	}
	
	public function printShopOrderCG() {
		$orderList = $this->getShopOrderValid ();
		$obj = new ShopOrderController ();
		$_html = '<style>
					html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,input,button,textarea,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summargy,time,margk,audio,video,select{margin:0;padding:0}
					body{background:#fff;font-size:14px;font-family:"宋体"}
					h1{ text-align:center;font-size:25px;font-family:"方正正中黑简体";margin-top:20px; font-weight:normal}
					.cgd_1{ width:90%;margin:0 auto}
					.cgd_1 th{height:40px;line-height:40px;}
					.cgd_1 td{ border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;height:40px;line-height:40px;padding-left:10px;}
					.cgd_1 p{ float:left; overflow:hidden;zoom:1;margin-right:20px;}
					.cgd_1 p input{ float:left;margin-top:14px;margin-right:5px;border:#000 solid 1px;}
					.cgd_2{width:90%;margin:20px auto 0;border-top:#000 solid 1px;border-left:#000 solid 1px;}
					.cgd_2 th{height:40px;line-height:40px;border-right:1px solid #000;border-bottom:#000 solid 1px;}
					.cgd_2 td{ border-right:1px solid #000;border-bottom:1px solid #000;height:30px;line-height:30px;padding-left:10px;}
				   </style>
					<h1>宠业无忧·总采购单</h1>
					<table class="cgd_1" cellpadding="0" cellspacing="0" border="0">
					<tr>
					<th align="left" >订单号：</th>
					<th colspan="2" align="right">宠业无忧全国统一客服热线:4007-007-580</th>
					</tr>
					<tr>
					<td style="border-left:1px solid #000;" width="50%"><p>□北京</p><p>□上海</p><p>□广州</p><p>□深圳</p></td>
					<td width="20%">采购人：</td>
					<td width="30%">采购时间：' . date ( 'Y年m月d日' ) . '</td>
					</tr>
					</table>
					<table cellpadding="0" cellspacing="0" border="0" class="cgd_2">
					<tr>
					<th width="50%">货品名称</th>
					<th width="10%" align="center">规格</th>
					<th width="10%" align="center">单位</th>
					<th width="10%" align="center">数量</th>
					<th width="10%" align="center">单价</th>
					<th width="10%" align="center">合计</th>
					<th width="10%" align="center">北京</th>
					<th width="10%" align="center">深圳</th>
					<th width="10%" align="center">广州</th>
					</tr>
					';
		$_arr = array ();
		$_arr ['pro'] = '';
		$_arr ['total'] = '';
		foreach ( $orderList as $k => $v ) {
			$orderDetail = $obj->getShopOrderChildrenDetail ( $v ['id'] );
			foreach ( $orderDetail as $ok => $ov ) {
				$_arr ['pro'] [$ov ['pId']] ['ePrice'] = $ov ['ePrice'];
				$_arr ['pro'] [$ov ['pId']] ['pTitle'] = $ov ['pTitle'];
				if (isset ( $_arr ['pro'] [$ov ['pId']] ['eNum'] )) {
					$_arr ['pro'] [$ov ['pId']] ['eNum'] = floatval ( $_arr ['pro'] [$ov ['pId']] ['eNum'] ) + floatval ( $ov ['eNum'] );
				} else {
					$_arr ['pro'] [$ov ['pId']] ['eNum'] = floatval ( $ov ['eNum'] );
				}
				if (isset ( $_arr ['pro'] [$ov ['pId']] ['tPrice'] )) {
					$_arr ['pro'] [$ov ['pId']] ['tPrice'] = floatval ( ($_arr ['pro'] [$ov ['pId']] ['tPrice']) ) + floatval ( $ov ['tPrice'] );
				} else {
					$_arr ['pro'] [$ov ['pId']] ['tPrice'] = floatval ( $ov ['tPrice'] );
				}
			}
			$_arr ['total'] = floatval ( $_arr ['total'] ) + floatval ( $v ['oMoney'] );
		}
		$_tmpHtml = '';
		if ($_arr ['pro'] == '') {
			echo '';
			exit ();
		}
		$_city = Run::req('_city');
		foreach ( $_arr ['pro'] as $key => $val ) {
			$pro = $this->getShopProDetail ( $key,$_city );
			$_tmpHtml .= '<tr>
							<td>' . $val ['pTitle'] . '</td>
							<td>' . $pro ['sNorms'] . '</td>
							<td>' . $pro ['sUnit'] . '</td>
							<td>' . $val ['eNum'] . '</td>
							<td>' . $val ['ePrice'] . '</td>
							<td>' . $val ['tPrice'] . '</td>
							<td></td>
							<td></td>
							<td></td>
						  </tr>';
		}
		$_html .= $_tmpHtml . '	<tr><td colspan="9" align="right" style="padding-right:10px;height:30px;line-height:30px;font-weight:bold">总计:' . $_arr ['total'] . '</td></tr>
					<tr><td  width="50%" style="border-right:none;padding-top:20px;">采购负责人签字：______________ </td><td colspan="8" align="right" style="padding-right:10px;padding-top:20px;">入库负责人签字：______________</td></tr>
					<tr><td colspan="9" align="center" style="font-size:16px;font-family:\'方正正中黑简体\';height:50px;line-height:50px;">宠业无忧 宠物服务行业生态平台</td></tr>
					</table>';
		echo $_html;
		exit ();
	}
	
	public function printShopOrderList() {
		$_oid = Run::req ( '_oid' );
		$sObj = new ShopOrderController ();
		$orderList = $sObj->getShopOrderDetail ( $_oid );
		$_html = '<style>
					html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,input,button,textarea,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summargy,time,margk,audio,video,select{margin:0;padding:0}
					body{background:#fff;font-size:14px;font-family:"宋体"}
					h1{ text-align:center;font-size:25px;font-family:"方正正中黑简体";margin-top:20px; font-weight:normal}
					.cgd_1{ width:90%;margin:0 auto;}
					.cgd_1 th{height:40px;line-height:40px;border-bottom:1px solid #000;}
					.cgd_1 td{ border-right:1px solid #000;border-bottom:1px solid #000;height:40px;line-height:40px;padding-left:10px;}
					.cgd_1 p{ float:left; overflow:hidden;zoom:1;margin-right:20px;}
					.cgd_1 p input{ float:left;margin-top:14px;margin-right:5px;border:#000 solid 1px;}
					.cgd_2{width:90%;margin:20px auto 0;border-top:#000 solid 1px;border-left:#000 solid 1px;}
					.cgd_2 th{height:40px;line-height:40px;border-right:1px solid #000;border-bottom:#000 solid 1px;}
					.cgd_2 td{ border-right:1px solid #000;border-bottom:1px solid #000;height:30px;line-height:30px;padding-left:10px;}
					.cwzy span{ float:left; width:33%; text-align:center}
					
					.cgd_2 p{ float:left; overflow:hidden;zoom:1;margin-right:20px;}
					.cgd_2 p input{ float:left;margin-top:9px;margin-right:5px;border:#000 solid 1px;}				
				</style>';
		$obj = new ShopOrderController ();
		$_tmpHtml = '';
		$_tmpHtml .= '<div>
					<h1>宠业无忧·货品配送单</h1>
					<table class="cgd_1" cellpadding="0" cellspacing="0" border="0">
					<tr>
					<th align="left" >订单号：' . $orderList ['id'] . '</th>
					<th colspan="2" align="right">宠业无忧全国统一客服热线:4007-007-580</th>
					</tr>
					<tr>
						<td  width="50%" style="border-left:1px solid #000;"><p>□北京</p><p>□上海</p><p>□广州</p><p>□深圳</p></td>
						<td width="20%" >配送员：</td>
						<td width="30%" >配送时间：</td>
					</tr>
					<tr><td style="border-left:1px solid #000;">' . $orderList ['oShopName'] . '</td><td>收货人：' . $orderList ['oName'] . '</td><td>电话：' . $orderList ['oTel'] . '</td></tr>
					<tr><td colspan="3" style="border-left:1px solid #000;">收货地址：' . $orderList ['oAddress'] . '</td></tr>
					</table>
					<table cellpadding="0" cellspacing="0" border="0" class="cgd_2">
					<tr>
					<th width="50%">货品名称</th>
					<th width="10%" align="center">规格</th>
					<th width="10%" align="center">单位</th>
					<th width="10%" align="center">数量</th>
					<th width="10%" align="center">单价</th>
					<th width="10%" align="center">合计</th>
					</tr>';
		$orderDetail = $obj->getShopOrderChildrenDetail ( $orderList ['id'] );
		$_tmpHtml0 = '';
		$_city =  $orderList ['city'] ;
		foreach ( $orderDetail as $ok => $ov ) {
			$pro = $this->getShopProDetail ( $ov ['pId'],$_city );
			$_tmpHtml0 .= '<tr>
							<td>' . $ov ['pTitle'] . '</td>
							<td>' . $pro ['sNorms'] . '</td>
							<td>' . $pro ['sUnit'] . '</td>
							<td>' . $ov ['eNum'] . '</td>
							<td>' . $ov ['ePrice'] . '</td>
							<td>' . $ov ['tPrice'] . '</td>					
						  </tr>';
		}
		if(empty($orderList['payCode'])){
			$_payStr = '贷到付款';
		}else{
			$_payStr = '在线支付';
		}
		$_tmpHtml .= $_tmpHtml0 . '<tr><td colspan="6" align="right" style="padding-right:10px;height:30px;line-height:30px;font-weight:bold">总计:' . $orderList ['oMoney'] . '</td></tr>
					<tr><td colspan="6" ><strong>付款方式：' . $_payStr . '</strong></td></tr>
					<tr><td ><strong>原价：' . $orderList ['oMoney'] . '</strong></td><td colspan="2"  ><strong>优惠：' . $orderList ['dMoney'] . '</strong></td><td colspan="3"  ><strong>实收：' . $orderList ['nMoney'] . '<strong></td></tr>
					</table>
					<table cellpadding="0" cellspacing="0" border="0" class="cgd_2">
					<tr><th colspan="6">收货确认</th></tr>
					<tr><td colspan="6"><p>□蛋糕兑换券</p><p>□磨剪刀代金券</p><p>□培训课堂入场券</p><p>□主题大礼包</p></td></tr>
					<tr><td colspan="6"><p>□货品和订单一致</p><p>□货品完好</p><p>其它：</p></td></tr>
					<tr><td colspan="6" class="cwzy">财务专员：吕文艳&nbsp;&nbsp;&nbsp;联系电话：15911008130&nbsp;&nbsp;&nbsp;微信：L15911008130</td></tr>
					<tr><td colspan="6">收款账号（支付宝）：zhifubao@momopet.cn</td></tr>
					<tr><td  width="50%" style="border-right:none;padding-top:20px;">收款人签字：______________ </td><td colspan="5" align="right" style="padding-right:10px;padding-top:20px;">收货人签字：______________</td></tr>
					<tr><td colspan="6" align="center" style="font-size:16px;font-family:\'方正正中黑简体\';height:50px;line-height:50px;">宠业无忧 宠物服务行业生态平台</td></tr>
					</table>
					</div>';
		echo $_html . $_tmpHtml;
		exit ();
	}

}