<?php
final class AdminEuiController extends Base {
	
	public function getAdminList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$aeObj = new AdminModel ();
		$res = $aeObj->getAdminUsers ( '', '', $limit );
		$aeObj->setField ( 'count(id) as total' );
		$totalRes = $aeObj->getAdminUsers ( '', '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	public function getAdminComBox() {
		$t = Run::req ( 't' );
		if ($t == '1') {
			$_arr = array (	
					array ('uType' => '1', 'uTypeName' => '系统管理员' ), 
					array ('uType' => '2', 'uTypeName' => '保险部' ),
					array ('uType' => '3', 'uTypeName' => '客服部' ),
					array ('uType' => '4', 'uTypeName' => '采购部' ),
					array ('uType' => '5', 'uTypeName' => '活动部' ),
					array ('uType' => '6', 'uTypeName' => '运营部' ),
					array ('uType' => '7', 'uTypeName' => '技术部' ),
					array ('uType' => '8', 'uTypeName' => '财务部' ),
					array ('uType' => '9', 'uTypeName' => '人事部' ),
					);
		} elseif ($t == '2') {
			$_arr = array (array ('uStatus' => '1', 'uStatusName' => '正常' ), array ('uStatus' => '2', 'uStatusName' => '禁用' ) );
		}
		echo json_encode ( $_arr );
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
		//var_dump($res);
		if (empty ( $res )) {
			echo '0';
		} else {
			$_SESSION [APP_NAME . '_admin_'] = $res;
			echo "1";
		}
		
	}
	
	public function logoutAdmin() {
		unset ( $_SESSION [APP_NAME . '_admin_'] );
		Run::show_msg('','','../login.html');
	}
	
	public function checkIsLoginAuth(){
		$res = $_SESSION [APP_NAME . '_admin_'];
		echo json_encode($res);
	}
	
	public function checkIsLogin() {
		if (isset ( $_SESSION [APP_NAME . '_admin_'] )) {
			echo 1;
		} else {
			echo 0;
		}
	}
	
	public function checkUName($_name) {
		$obj = D ( 'Admin' );
		$res = $obj->getAdminUsers ( " uName='{$_name}' ", '', '1', '1' );
		if (empty ( $res )) {
			return true;
		} else {
			echo 0;
			exit ();
		}
	}
	
	public function saveAdminUsers() {
		$_id = Run::req ( 'id' );
		
		$_d ['uName'] = Run::req ( 'uName' );
		$_d ['uPwd'] = Run::req ( 'uPwd' );
		$_d ['uType'] = Run::req ( 'uType' );
		$_d ['uStatus'] = Run::req ( 'uStatus' );
		$_d ['rbac'] = Run::req ( 'rbac' );
		
		$sObj = D ( 'Admin' );
		if ($_id) {
			$res = $sObj->setAdminUsers ( $_id, $_d );
		} else {
			$this->checkUName ( $_d ['uName'] );
			$res = $sObj->addAdminUsers ( $_d );
		}
		
		if ($res) {
			echo 1;
		}
	}
	
	public function leftTree(){
		$_userTree = array(
					'text'=>'用户',
					'state'=>'open',
					'children'=>array(
						array('id'=>'user.reg.list','text'=>'注册用户'),
						)
					);
		$_insTree = array(
					'text'=>'保险单',
					'state'=>'open',
					'children'=>array(
						array('id'=>'ins.import.file.list','text'=>'导入保单'),
						array('id'=>'ins.list','text'=>'保单信息'),
						array('id'=>'ins.pay.list','text'=>'支付记录'),
						array('id'=>'ins.member.list','text'=>'保单人'),
						array('id'=>'ins.price.list','text'=>'价格配置'),
						)
					);
		$_serTree = array(
					'text'=>'保单服务人',
					'state'=>'open',
					'children'=>array(
						array('id'=>'service.mem.list','text'=>'服务人员'),
						)
					);
		$_signTree = array(
					'text'=>'签到系统',
					'state'=>'open',
					'children'=>array(
						array('id'=>'sign.date.config.list','text'=>'配置月份'),
						array('id'=>'sign.news.config.list','text'=>'新闻推送'),
						array('id'=>'sign.winpro.config.list','text'=>'奖品配置'),
						array('id'=>'sign.main.list','text'=>'签到用户'),
						array('id'=>'sign.main.record.list','text'=>'签到记录'),
						array('id'=>'sign.winpro.record.list','text'=>'奖励记录'),
						)
					);
		$_mjdTree = array(
					'text'=>'磨剪刀',
					'state'=>'open',
					'children'=>array(
						array('id'=>'repair.price.list','text'=>'价格配置'),
						array('id'=>'repair.order.list','text'=>'产品订单'),
						)
					);
		$_cakeTree = array(
					'text'=>'蛋糕产品',
					'state'=>'open',
					'children'=>array(
						array('id'=>'cake.pro.list','text'=>'蛋糕产品'),
						array('id'=>'cake.order.list','text'=>'蛋糕订单列表'),
						)
					);
		$_groTree = array(
					'text'=>'商户用户',
					'state'=>'open',
					'children'=>array(
						array('id'=>'cake.shop.list','text'=>'商户记录'),
						array('id'=>'shop.special.list','text'=>'专员列表'),
						)
					);
		$_mallTree = array(
					'text'=>'商城',
					'state'=>'open',
					'children'=>array(
						array('id'=>'shop.cate.list','text'=>'商城分类'),
						array('id'=>'shop.pro.100001.list','text'=>'北京商品列表'),
						array('id'=>'shop.pro.200001.list','text'=>'上海商品列表'),
						array('id'=>'shop.pro.300001.list','text'=>'深圳商品列表'),
						array('id'=>'shop.pro.400001.list','text'=>'其它城市商品列表'),
						array('id'=>'shop.check.pro.list','text'=>'检验商品'),
						array('id'=>'shop.check.pro.stock.list','text'=>'商品库存统计'),
						array('id'=>'shop.demand.list','text'=>'用户需求'),						
						array('id'=>'shop.marketing.list','text'=>'促销'),
						array('id'=>'shop.order.express.money.list','text'=>'配送费'),
						//array('id'=>'shop.vendor.list','text'=>'供应商'),
						//array('id'=>'shop.vendor.pro.list','text'=>'供应商报价'),						
						)
					);
		$_cityBJTree = array(
					'text'=>'北京订单',
					'state'=>'open',
					'children'=>array(						
						array('id'=>'shop.order.100001.list','text'=>'北京订单')
					)
		);
		$_citySHTree = array(
					'text'=>'上海订单',
					'state'=>'open',
					'children'=>array(						
						array('id'=>'shop.order.200001.list','text'=>'上海订单')
					)
		);
		$_citySZTree = array(
					'text'=>'深圳订单',
					'state'=>'open',
					'children'=>array(						
						array('id'=>'shop.order.300001.list','text'=>'深圳订单')
					)
		);
		$_mallOrderTree = array(
					'text'=>'商城订单',
					'state'=>'open',
					'children'=>array(
						array('id'=>'shop.order.list','text'=>'商品总订单'),
						array('id'=>'shop.order.express.list','text'=>'订单物流'),
						array('id'=>'shop.order.log.list','text'=>'订单日志'),
						array('id'=>'shop.order.pro.lack.list','text'=>'缺货登记')
						)
					);
		$_medicineTree = array(
					'text'=>'药品',
					'state'=>'closed',
					'children'=>array(
						array('id'=>'medicine.notice.list','text'=>'药品提示'),
						)
					);
		$_actTree = array(
					'text'=>'活动',
					'state'=>'closed',
					'children'=>array(
						array('id'=>'act.20151202','text'=>'20151202 活动'),
						array('id'=>'act.20151216','text'=>'20151216 活动'),
						array('id'=>'act.20160105','text'=>'20160105 活动'),
						array('id'=>'act.20160120','text'=>'20160120 活动'),
						array('id'=>'act.20160122','text'=>'20160122 活动'),
						array('id'=>'act.20160315','text'=>'20160315 活动'),
						array('id'=>'act.20160405','text'=>'20160405 活动'),
						)
					);
		$_sysTree = array(
					'text'=>'系统',
					'state'=>'open',
					'children'=>array(
						array('id'=>'sys.picture.list','text'=>'首页轮播'),
						array('id'=>'sys.cate.list','text'=>'系统分类'),
						array('id'=>'user.admin.list','text'=>'管理员'),
						)
					);
		$_endTree = array(
			$_userTree,$_insTree,$_serTree,$_signTree,$_mjdTree,$_cakeTree,
			$_groTree,$_mallTree,$_cityBJTree,$_citySHTree,$_citySZTree,$_mallOrderTree,$_actTree,
			$_medicineTree,
			$_sysTree
		);
		return $_endTree;
	}
	
	public function getLeftCombox(){
		$res = $this->leftTree();
		$_arr = array();
		foreach ($res as $k=>$v){
			$_arr[]['rbac'] = $v['text'];	
		}
		echo json_encode($_arr);
	}
	
	
	public function getCheckLeftResult(){
		if(isset($_SESSION [APP_NAME . '_admin_'])){
			$adminRes = $_SESSION [APP_NAME . '_admin_'];
			$res = $this->leftTree();
			$_arr = array();
			$_str = explode(',', $adminRes['rbac']);
			foreach ($res as $k=>$v){
				if(in_array($v['text'], $_str)){
					$_arr[] = $v;
				}
			}
			echo json_encode($_arr);exit;
		}else{
			echo '';exit();
		}
	}
}