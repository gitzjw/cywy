<?php
final class ShopProController extends Base {
	
	public function getShopProWtype() {
		$shopObj = new CakeShopController();
		$_shopRes = $shopObj->getCakeShopUid(1);
		
		if(!isset($_shopRes['city']) || empty($_shopRes['city'])){
			$shopObj = new ShopSpeUserController();
			$_shopRes = $shopObj->getShopSpeUserOpenId();
		}
		
		$obj = new ShopProModel ();
		$obj->setTableCity($_shopRes['city']);
		$_index = Run::req ( '_index' );
		$_wtype = Run::req ( '_wtype' );
		$obj->setField ( 'id,wType,listImgPath,title,oPrice,dPrice,isSingle,nPrice,oNum,sNum,nNum,speMark,marketPrice' );
		$w = ' wType="' . $_wtype . '"  and spStatus="1" ';
		
		if ($_index == '1') {
			$w .= 'and isIndex="1"';
		}
		
		$res = $obj->getShopPro ( $w, ' aLif ASC,spSort ASC ' );
		$this->_jsonEn ( '1', $res );
	}
	
	public function getShopProAct(){
		$shopObj = new CakeShopController();
		$_shopRes = $shopObj->getCakeShopUid(1);
		
		if(!isset($_shopRes['city']) || empty($_shopRes['city'])){
			$shopObj = new ShopSpeUserController();
			$_shopRes = $shopObj->getShopSpeUserOpenId();
		}
		
		$obj = new ShopProModel ();
		$obj->setTableCity($_shopRes['city']);
		$obj->setField ( 'id,wType,listImgPath,title,sUnit,oPrice,dPrice,nPrice,oNum,sNum,nNum,speMark,marketPrice' );
		if($_shopRes['city']=='100001'){
			$w = ' id in (2391,2392,2393,2394,2395,2396,2397,2398,2399,2400,2401)';
		}elseif($_shopRes['city']=='200001'){
			$w = ' id in (3418,3419,3420,3421,3422,3423,3424)';
		}elseif($_shopRes['city']=='300001'){
			$w = ' id in (3154,3156,3157,3158,3159,3160,3162,2449)';
		}		
		
		$res = $obj->getShopPro ( $w, ' isTop desc,spSort desc' );
		return $res;
	}
	
	public function getShopProDetail() {
		$_id = Run::req ( 'i' );
		$shopObj = new CakeShopController();
		$_shopRes = $shopObj->getCakeShopUid(1);
		
		if(!isset($_shopRes['city']) || empty($_shopRes['city'])){
			$shopObj = new ShopSpeUserController();
			$_shopRes = $shopObj->getShopSpeUserOpenId();
		}
		
		$obj = new ShopProModel ();
		$obj->setTableCity($_shopRes['city']);
		$res = $obj->getShopPro ( 'id="' . $_id . '"', '', '', '1' );
		if ($res) {
			$this->_jsonEn ( '1', $res );
		} else {
			$this->_jsonEn ( '605', '没有该商品' );
		}
	}
	
	public function shopCar() {
		$obj = new ParamsController ();
		$_shopName = 'shopCar';
		$_tmpArr = $obj->getSessionParams ( $_shopName );
		$_str = Run::req ( '_data' );
		if ($_str != '') {
			$_tmpStr = explode ( '@-@-@', $_str );
			$_tmpArr ['car'] [$_tmpStr [0]] = $_tmpStr;
			$_tmpArr ['totalNum'] = Run::req ( 'totalNum' );
			$_tmpArr ['totalPrice'] = Run::req ( 'totalPrice' );
			$obj->localSetParams ( $_shopName, $_tmpArr );
		}
		if (empty ( $_tmpArr )) {
			$this->_jsonEn ( '601', '购物车没有物品' );
		} else {
			$this->_jsonEn ( '1', $_tmpArr );
		}
	
	}

	public function setShopCarData() {
		$car = $_REQUEST ['car'];
		$obj = new ParamsController ();
		$_shopName = 'shopCar';
		$car = json_decode ( $car, true );
		$_tmpArr = $obj->getSessionParams ( $_shopName );
		foreach ($car ['msg'] ['car'] as $k=>$v){
			if(!empty($v) && $k!='undefined'){
				$_tmpArr ['car'][$k] = $v;
			}
		}
		$_tmpArr ['totalNum'] = $car ['msg'] ['totalNum'];
		$_tmpArr ['totalPrice'] = $car ['msg'] ['totalPrice'];
		if(isset($car ['msg'] ['totalOPrice'])){
			$_tmpArr ['totalOPrice'] = $car ['msg'] ['totalOPrice'];
		}
		$obj->localSetParams ( $_shopName, $_tmpArr );
	}
	
	public function shopLeftCar(){
		$obj = new ParamsController ();
		$_shopName = 'shopLeftCarNum';
		$_tmpArr = $obj->getSessionParams ( $_shopName );
		$_str = Run::req ( '_data' );
		if ($_str != '') {
			
		}
		if (empty ( $_tmpArr )) {
			$this->_jsonEn ( '601', '购物车没有物品' );
		} else {
			$this->_jsonEn ( '1', $_tmpArr );
		}
	}
	
	public function setShopLeftCarData(){
		$car = $_REQUEST ['car'];
		$obj = new ParamsController ();
		$_shopName = 'shopLeftCarNum';
		$car = json_decode ( $car, true );
		$_tmpArr = $obj->getSessionParams ( $_shopName );
		foreach ($car ['msg'] ['leftcar'] as $k=>$v){
			if(!empty($v) && $k!='undefined'){
				$_tmpArr ['leftcar'][$k] = $v;
			}
		}
		$obj->localSetParams ( $_shopName, $_tmpArr );
	}
	
	public function shopLeftCarDel(){
		$_id = Run::req ( 'i' );
		$_shopName = 'shopLeftCarNum';
		$obj = new ParamsController ();
		if ($_id) {
			$_tmpArr = $obj->getSessionParams ( $_shopName );
			if(isset($_tmpArr ['leftcar'] [$_id])){
				unset ( $_tmpArr ['leftcar'] [$_id] );
				$obj->localSetParams ( $_shopName, $_tmpArr );
			}			
		} else {
			$obj->localSetParams ( $_shopName, null );
		}
	}
	
	public function shopCarDel() {
		$_id = Run::req ( 'i' );
		$_price = Run::req ( 'price' );
		$_shopName = 'shopCar';
		$obj = new ParamsController ();
		if ($_id) {
			$_tmpArr = $obj->getSessionParams ( $_shopName );
			if(isset($_tmpArr ['car'] [$_id])){
				unset ( $_tmpArr ['car'] [$_id] );
				$_tmpArr ['totalNum'] = intval ( $_tmpArr ['totalNum'] ) - 1;
				$_tmpArr ['totalPrice'] = floatval ( $_tmpArr ['totalPrice'] ) - $_price;
				if ($_tmpArr ['totalNum'] == '0') {
					$obj->localSetParams ( $_shopName, null );
				} else {
					$obj->localSetParams ( $_shopName, $_tmpArr );
				}
			}			
		} else {
			$obj->localSetParams ( $_shopName, null );
		}
	}
	//海淘类型判断
	public function addCarTypeIf(){
		$id = $_REQUEST ['id'];
		$goods = $_REQUEST ['goods'];
		$HT = 'no'; //商品
		$shopHT = 'no';//购物车商品
		$Obj = new ShopProModel();
		$parentId = $Obj->getGoodType($id);
		if($parentId['parentId'] == 298){
			$HT = 'yes';
		}
		//echo $parentId['parentId']."/".$HT;
		if($goods==null){
			$this->_jsonEn ( 'true',  $HT);die;
		}else{
			$goodsid = json_decode($goods,true);
			if($goodsid['code']=='601'){
				$this->_jsonEn ( 'true', $HT );die;
			}
			if(empty($goodsid['msg']['car'])){
				$this->_jsonEn('true',$HT);die;
			}

		}
		//print_r($goodsid['msg']['car']);
		foreach ($goodsid['msg']['car'] as $car_id => $item) {
			if (empty($car_id) or empty($item['0']) or $car_id =='undefined') {
				continue;
			}
			$parentId = $Obj->getGoodType($item['0']);
			if($parentId['parentId'] == 298){
				$shopHT = 'yes';
			}

		}
		//echo $shopHT;
		if($HT =='yes'  and $shopHT == 'yes'){
			$this->_jsonEn ( 'true', $HT );
		}elseif($HT=='no' and $shopHT == 'no'){
			$this->_jsonEn ( 'true', $HT );
		}else{
			$this->_jsonEn ( 'false', '海淘商品和普通商品不能同时下单,可以清空购物车,分开下单!' );

		}
	}

}