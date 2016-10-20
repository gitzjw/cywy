<?php
final class ShopProEuiController extends Base {
	
	public function getShopProList() {
		$_p = Run::req ( 'page' );
		$_p = (empty ( $_p ) || $_p < 0) ? 0 : $_p - 1;
		$_page = Run::req ( 'rows' );
		$_page_prev = intval ( $_p ) * intval ( $_page );
		$limit = $_page_prev . ',' . $_page;
		$ueObj = new ShopProModel ();
		$_tab = Run::req('_tab');
		$ueObj->setTableCity($_tab);
		$ueObj->setField ( '*,(select sName from shop_type s where s.id=wType) as wTypeName' );
		$w = $this->getWhere ();
		$res = $ueObj->getShopPro ( $w, '', $limit );
		$ueObj->setField ( 'count(id) as total' );
		$totalRes = $ueObj->getShopPro ( $w, '', '', '1' );
		$_tmpRes = array ('total' => $totalRes ['total'], 'rows' => $res );
		echo json_encode ( $_tmpRes );
	}
	
	private function getWhere() {
		$w = ' 1 ';
		$_name = Run::req ( '_name' );
		$_sts = Run::req('_stst');
		$_txm = Run::req ( '_txm' );
		$_id = Run::req('_id');
		$_wt = Run::req('_wt');		
		if (! $_name && !$_sts && !$_txm && !$_id && !$_wt) {
			$w = '';
		} else {
			$w = '1';
		}
		if ($_name) {
			$w .= ' and title like "%' . $_name . '%" ';
		}
		if ($_sts) {
			$w .= ' and spStatus= "'.$_sts.'" ';
		}
		if ($_txm) {
			$w .= ' and sptm= "'.$_txm.'" ';
		}
		if ($_id) {
			$w .= ' and id= "'.$_id.'" ';
		}
		if ($_wt) {
			$obj = new ShopTypeModel();
			$obj->setField('id');
			$res = $obj->getShopType('parentId="'.$_wt.'" and cStatus="1" ');
			if(empty($res)){
				$w .= ' and wType="'.$_wt.'" ';
			}else{
				$_tmpStr = '';
				foreach ($res as $k=>$v){
					if($k==0){
						$_tmpStr .= $v['id'];
					}else{
						$_tmpStr .= ','.$v['id'];
					}
				}
				$w .= ' and wType in ('.$_tmpStr.') ';
			}			
		}
		return $w;
	}
	

	public function getShopProSelectHtml(){
		$_name = Run::req('_name');
		$_name = $_name?$_name:'pId';
		
		$obj = new ShopProModel();
		
		$_tab = Run::req('_tab');
		$obj->setTableCity($_tab);
		
		$data = $obj->getShopPro('',' aLif ');
		
		$_html = '<select name="' . $_name . '">';
		foreach ( $data as $ok => $ov ) {
			$_html .= "<option value='{$ov['id']}' _wtype='{$ov['wType']}'>{$ov['title']}</option>";
		}
		$_html .= '</select>';
		echo $_html;
	}
	
	public function updateStatus() {
		$_s = Run::req ( '_s' );
		$_id = Run::req ( '_id' );
		$obj = new ShopProModel ();
		
		$_tab = Run::req('_tab');
		$obj->setTableCity($_tab);
		
		$data ['spStatus'] = $_s;
		$res = $obj->setShopPro ( $_id, $data );
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function updateTop() {
		$_top = Run::req ( '_top' );
		$_id = Run::req ( '_id' );
		$obj = new ShopProModel ();
		
		$_tab = Run::req('_tab');
		$obj->setTableCity($_tab);
		
		$data ['isTop'] = $_top;
		$res = $obj->setShopPro ( $_id, $data );
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function saveShopPro() {
		$_id = Run::req ( 'id' );
		
		$_d ['title'] = Run::req ( 'title' );
		
		$_d ['oNum'] = Run::req ( 'oNum' );
		$_d ['sNum'] = Run::req ( 'sNum' );
		$_d ['nNum'] = Run::req ( 'nNum' );
		
		$_d ['oPrice'] = Run::req ( 'oPrice' );
		$_d ['dPrice'] = Run::req ( 'dPrice' );
		$_d ['nPrice'] = Run::req ( 'nPrice' );
		if ($_d ['nPrice'] == '') {
			$_d ['nPrice'] = floatval ( $_d ['oPrice'] ) - floatval ( $_d ['dPrice'] );
		} 
		
		$img1 = $this->uploadImg ( $_FILES ['upload1'] );
		if ($img1) {
			$_d ['dImgPath'] = $img1;
		} else {
			$_d ['dImgPath'] = Run::req ( 'dImgPath' );
		}
		
		$listImg = $this->uploadImg ( $_FILES ['listimg'] );
		if ($listImg) {
			$_d ['listImgPath'] = $listImg;
		} else {
			$_d ['listImgPath'] = Run::req ( 'listImgPath' );
		}
		
		$_d ['wType'] = Run::req ( 'wType' );
		$_d ['sNorms'] = Run::req ( 'sNorms' );
		$_d ['sUnit'] = Run::req ( 'sUnit' );
		$_d ['isTop'] = Run::req ( 'isTop' );
		$_d['isSingle'] = Run::req('isSingle');
		$_d ['spSort'] = Run::req ( 'spSort' );
		$_d ['isIndex'] = Run::req ( 'isIndex' );
		$_d ['aLif'] = Run::req ( 'aLif' );
		$_d ['spDesc'] = Run::req ( 'spDesc' );
		$_d ['spContent'] = Run::req ( 'content' );
		$_d ['spStatus'] = Run::req ( 'spStatus' );
		$_d ['goodsNote'] = Run::req ( 'goodsNote' );
		$_d ['sptm'] = Run::req ( 'sptm' );
		$_d ['sUnitNum'] = Run::req ( 'sUnitNum' );
		$_d ['marketPrice'] = Run::req ( 'marketPrice' );
		$_d ['speMark'] = Run::req ( 'speMark' );
		
		$sObj = new ShopProModel ();
		
		$_tab = Run::req('_tab');
		$sObj->setTableCity($_tab);
		
		if ($_id) {
			$res = $sObj->setShopPro ( $_id, $_d );
		} else {
			$res = $sObj->addShopPro ( $_d );
			$sObj->setTableCity('200001');
			$res = $sObj->addShopPro ( $_d );
			$sObj->setTableCity('300001');
			$res = $sObj->addShopPro ( $_d );
			$sObj->setTableCity('400001');
			$res = $sObj->addShopPro ( $_d );
		}
		
		if ($res) {
			echo '操作成功';
		} else {
			echo '操作失败';
		}
	}
	
	public function getProMinNum(){
		$_bj = 'http://180.167.66.14:8097/GetData.aspx?action=getbjonhands&key=meng';		
		$_bjRes = Run::getHttpRes($_bj);
		$_bjRes = json_decode($_bjRes,true);
		$_bjResE = null;
		foreach ($_bjRes as $bk=>$bv){
			$_bjResE[$bv['sptm']] = $bv;
		}
		$_sh = 'http://180.167.66.14:8097/GetData.aspx?action=getshonhands&key=meng';
		$_shRes = Run::getHttpRes($_sh);
		$_shRes = json_decode($_shRes,true);
		$_shResE = null;
		foreach ($_shRes as $sk=>$sv){
			$_shResE[$sv['sptm']] = $sv;
		}
		
		$obj = new ShopProModel();
		$obj->setTableCity('100001');
		$obj->setField('sptm,sUnitNum,title');
		$_proRes = $obj->getShopPro();
		
		$_resArr = array();
		
		foreach ($_proRes as $k=>$v){
			$_resArr[$k]['d'] = $v;
			$_resArr[$k]['bj'] = isset($_bjResE[$v['sptm']])?$_bjResE[$v['sptm']]:array('minkys'=>0);
			$_resArr[$k]['sh'] = isset($_shResE[$v['sptm']])?$_shResE[$v['sptm']]:array('minkys'=>0);
			if($v['sUnitNum']<=$_resArr[$k]['bj']['minkys']){
				$_resArr[$k]['bjSts'] = '1';
			}else{
				$_resArr[$k]['bjSts'] = '0';
			}
			if($v['sUnitNum']<=$_resArr[$k]['sh']['minkys']){
				$_resArr[$k]['shSts'] = '1';
			}else{
				$_resArr[$k]['shSts'] = '0';
			}
		}
		
		$_html = '<table  class="easyui-datagrid" style="width:auto;height:auto;">
					<thead>
						<tr>
							<th field="a1" width="150">商品条形码</th>
							<th field="a2" width="250">商品名称</th>
							<th field="a4" width="50">比例</th>
							<th field="a5" width="100">北京库存量</th>
							<th field="a6" width="80">是否有货</th>
							<th field="a7" width="100">上海库存量</th>
							<th field="a8" width="80">是否有货</th>
					   </tr>
				    </thead>
				    <tbody>';
		foreach ($_resArr as $rk=>$rv){
			if($rv['bjSts']){
				$_bjsts = '<b style="color:green">有货</b>';
			}else{
				$_bjsts = '<b style="color:red">无货</b>';
			}
			if($rv['shSts']){
				$_shsts = '<b style="color:green">有货</b>';
			}else{
				$_shsts = '<b style="color:red">无货</b>';
			}
			$_html .= '<tr>
							<td>'.$rv['d']['sptm'].'</td>
							<td>'.$rv['d']['title'].'</td>
							<td>'.$rv['d']['sUnitNum'].'</td>
							<td>'.$rv['bj']['minkys'].'</td>
							<td>'.$_bjsts.'</td>
							<td>'.$rv['sh']['minkys'].'</td>
							<td>'.$_shsts.'</td>
					   </tr>';
		}
		$_html.='<tbody></table>';
		echo $_html;exit();
	}	
	
	public function setShopProSpe(){		
		$_wtype = Run::req('speType');
		if(!$_wtype){
			echo '请选择特价分类';exit;
		}
		$_id = Run::req('id1');
		$_price = Run::req('nPrice1');
		
		$obj = new ShopProModel();
		$_tab = Run::req('_tab');
		$obj->setTableCity($_tab);
		
		$_tmpRes = $obj->getShopPro('id="'.$_id.'"','','1','1');
		if($_tmpRes){
			$_tmpRes['wType'] = $_wtype;
			if($_price){
				$_tmpRes['nPrice'] = $_price;
			}			
			$_tmpRes['speMark'] = 1;
			$_tmpRes['spContent'] = addslashes($_tmpRes['spContent']);
			$res = $obj->addShopPro($_tmpRes);
			if ($res) {
				echo '操作成功';
			} else {
				echo '操作失败';
			}
		}else{
			echo '未查询到数据';
		}
		
	}
	
	public function syncMysqlData(){
		$_city = Run::req('_city');
		
		switch ($_city) {
			case '200001':
				$this->_sycnOp($_city);
				break;
			case '300001':
				$this->_sycnOp($_city);
				break;
			case '400001':
				$this->_sycnOp($_city);
				break;
			default:
				$this->_sycnOp('100001');
				break;
		}
		echo '操作成功';
	}
	
	private function _sycnOp($_city){
		
		$_t = 'shop_pro_'.$_city;
		
		$sql = 'truncate '.$_t;
		
		$obj = new ShopProModel();		
		
		$obj->query($sql);
		
		$sql = 'INSERT INTO `'.$_t.'` SELECT * FROM `shop_pro_100001`';
		
		$obj->query($sql);
		
		if($_city=='400001'){
			$_percent = Run::req('_percent');
			if(empty($_percent)){
				
			}else{
				$sql = 'update shop_pro_400001 set nPrice=nPrice+(nPrice*'.$_percent.') ';
				$obj->query($sql);
			}			
		}
		return true;
	}
}